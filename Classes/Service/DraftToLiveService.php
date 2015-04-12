<?php
/*
 * Copyright (C) 2015 Valentin Zickner <valentin.zickner@helfenkannjeder.de>
 *
 * This file is part of HelfenKannJeder.
 *
 * HelfenKannJeder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HelfenKannJeder is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HelfenKannJeder.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Querformatik\HelfenKannJeder\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class is to publish an organisation. For this case, it copies all
 * Draft-Objects to the Live-Objects.
 *
 * @author Valentin Zickner
 */
class DraftToLiveService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 * @inject
	 */
	protected $draftRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * Copy an OrganisationDraft object to the corresponding Organisation object.
	 *
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 * @return void
	 */
	public function draft2live(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft) {
		$organisationDraft->setRequest(2);
		$organisationDraft->setRequesttime(time());
		$this->syncObject('\\Querformatik\\HelfenKannJeder\\Domain\\Model\\OrganisationDraft',
			'\\Querformatik\\HelfenKannJeder\\Domain\\Model\\Organisation', $organisationDraft);
		$this->draftRepository->update($organisationDraft);

		$this->persistenceManager->persistAll();
	}

	/**
	 * Syncs one object to an equal object.
	 */
	private function syncObject($srcClass, $destClass, &$srcObject, $methodsWalkedThrough = array()) {
		// Prove the parameters (srcClass is correct)
		if ($srcObject instanceof $srcClass) {
			// Use old reference or create new one.
			$destObject = $srcObject->getReference();

			if (in_array($srcObject->__toString(), $methodsWalkedThrough)) {
				return $destObject;
			}

			$methodsWalkedThrough[] = $srcObject->__toString();

			if (!($destObject instanceof $destClass) &&
				!($destObject instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy && $destObject->getUid() != 0)) {
				$destObject = new $destClass();
				$destObject->setReference($srcObject);
				$srcObject->setReference($destObject);
			}

			$srcMethods = get_class_methods($srcClass);
			$destMethods = get_class_methods($destClass);

			$objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
			$dataMapper = $objectManager->get('\\TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMapper');
			$reflectionService = $objectManager->get('\\TYPO3\\CMS\\Extbase\\Reflection\\ReflectionService');

			$dataMap = $dataMapper->getDataMap($srcClass);
			$classSchema = $reflectionService->getClassSchema($srcClass);

			foreach ($srcMethods as $srcMethod) {
				// Only use getter methods for finding arrays
				if (substr($srcMethod, 0, 3) == 'get' && $srcMethod != 'getReference' && $srcMethod != 'getUid' && $srcMethod != 'getPid') {
					$srcMethodAttribute = lcfirst(substr($srcMethod, 3));
					$destMethodSet = 'set' . substr($srcMethod, 3);
					$destMethodAdd = 'add' . substr($srcMethod, 3);
					$destMethodRemove = 'remove' . substr($srcMethod, 3);
					$columnMap = $dataMap->getColumnMap($srcMethodAttribute);
					$propertyData = $classSchema->getProperty($srcMethodAttribute);

					if ($columnMap instanceof \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap) {
						$getterResult = call_user_func(array(&$srcObject, $srcMethod));
						switch ($columnMap->getTypeOfRelation()) {
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_HAS_MANY:
								// Fallthrough, this is the same case
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_HAS_AND_BELONGS_TO_MANY:
								$destMethodAdd = substr($destMethodAdd, 0, -1);
								if (!in_array($destMethodAdd, $destMethods)) {
									$destMethodAdd = substr($destMethodAdd, 0, -1);
								}
								if (in_array($destMethodAdd, $destMethods) && in_array($srcMethod, $destMethods) && isset($propertyData['elementType'])) {
									$newName = $this->buildNewClassName($srcClass, $destClass, $propertyData['elementType']);
									if (class_exists($newName)) {
										foreach ($getterResult as $getterResultEntry) {
											$newCreatedObject = $this->syncObject($propertyData['elementType'], $newName, $getterResultEntry,
												$methodsWalkedThrough);
											$alreadyAdded = FALSE;
											$newObject = call_user_func(array(&$destObject, $srcMethod));
											if ($newCreatedObject->__toString() != $newName . ':') {
												foreach ($newObject as $newObjectEntry) {
													$alreadyAdded |= ($newObjectEntry->__toString() == $newCreatedObject->__toString());
												}
											}

											if (!$alreadyAdded) {
												if ($newCreatedObject instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
													$newCreatedObject = $newCreatedObject->_loadRealInstance();
												}
												call_user_func(array(&$destObject, $destMethodAdd), $newCreatedObject);
											}
										}
									} else {
										foreach ($getterResult as $getterResultEntry) {
											call_user_func(array(&$destObject, $destMethodAdd), $getterResultEntry);
										}
									}

									// DELETE unused elements
									if (!in_array($destMethodRemove, $destMethods)) {
										$destMethodRemove = substr($destMethodRemove, 0, -1);
									}
									$getterResultStrings = array();
									foreach ($getterResult as $getterResultObject) {
										if (is_object($getterResultObject)) {
											$getterResultStrings[] = $getterResultObject->__toString();
										}
									}
									if (in_array($destMethodRemove, $destMethods)) {
										$newObject = call_user_func(array(&$destObject, $srcMethod));
										foreach ($newObject as $newObjectEntry) {
											$ref = $newObjectEntry->getReference();
											$refOrg = $ref;
											if ($ref instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
												$ref = $ref->_loadRealInstance();
											}
											if (!($ref instanceof $propertyData['elementType']) || !in_array($refOrg->__toString(), $getterResultStrings)) {
												call_user_func(array(&$destObject, $destMethodRemove), $newObjectEntry);
											}
										}
									}
								}
								break;
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_HAS_ONE:
								if (in_array($destMethodSet, $destMethods)) {
									$newName = $this->buildNewClassName($srcClass, $destClass, $propertyData['type']);
									if (class_exists($newName)) {
										$newCreatedObject = $this->syncObject($propertyData['type'], $newName, $getterResult, $methodsWalkedThrough);
										call_user_func(array(&$destObject, $destMethodSet), $newCreatedObject);
									} else {
										call_user_func(array(&$destObject, $destMethodSet), $getterResult);
									}
								}
								break;
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_BELONGS_TO_MANY:
								break;
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_NONE:
								if (in_array($destMethodSet, $destMethods)) {
									call_user_func(array(&$destObject, $destMethodSet), $getterResult);
								}
								break;
							default:
								throw new \Exception('System error, missing ColumnMap.');
						}
					}
				}
			}

		}
		return $destObject;
	}

	private function buildNewClassName($oldClassName, $newClassName, $buildableClassName) {
		if (strlen($oldClassName) < strlen($newClassName)) {
			$buildableClassName .= substr($newClassName, strlen($oldClassName));
		} elseif (strlen($oldClassName) > strlen($newClassName)) {
			$buildableClassName = substr($buildableClassName, 0, strlen($newClassName) - strlen($oldClassName));
		}
		return $buildableClassName;
	}
}
