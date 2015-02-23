<?php
namespace Querformatik\HelfenKannJeder\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;


class DraftToLiveService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 * @inject
	 */
	protected $organisationDraftRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * Copy an OrganisationDraft object to the corresponding Organisation object.
	 *
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function draft2live(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft) {
		$organisationDraft->setRequest(2);
		$organisationDraft->setRequesttime(time());
		$destObject = $this->syncObject("\\Querformatik\\HelfenKannJeder\\Domain\\Model\\OrganisationDraft", "\\Querformatik\\HelfenKannJeder\\Domain\\Model\\Organisation", $organisationDraft);
		$this->organisationDraftRepository->update($organisationDraft);

		$this->persistenceManager->persistAll();
	}

	/**
	 * Syncs one object to an equal object.
	 */
	private function syncObject($srcClass, $destClass, &$srcObject, $methodsWalkedThrough=array()) {
		// Prove the parameters (srcClass is correct)
		if ($srcObject instanceof $srcClass) {
			// Use old reference or create new one.
			$destObject = $srcObject->getReference();

			if (in_array($srcObject->__toString(), $methodsWalkedThrough)) {
				return $destObject;
			}

			$methodsWalkedThrough[] = $srcObject->__toString();

			if (!($destObject instanceof $destClass) && !($destObject instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy && $destObject->getUid() != 0)) {
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
				if (substr($srcMethod,0,3) == "get" && $srcMethod != "getReference" && $srcMethod != "getUid" && $srcMethod != "getPid") { // Only use getter methods for finding arrays
					$srcMethodAttribute = lcfirst(substr($srcMethod,3));
					$destMethodSet = "set" . substr($srcMethod,3);
					$destMethodAdd = "add" . substr($srcMethod,3);
					$destMethodRemove = "remove" . substr($srcMethod,3);
					$columnMap = $dataMap->getColumnMap($srcMethodAttribute);
					$propertyData = $classSchema->getProperty($srcMethodAttribute);

					if ($columnMap instanceof \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap) {
						$getterResult = call_user_func(array(&$srcObject, $srcMethod));
						switch ($columnMap->getTypeOfRelation()) {
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_HAS_MANY:
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_HAS_AND_BELONGS_TO_MANY:
								$destMethodAdd = substr($destMethodAdd, 0, -1);
								if (!in_array($destMethodAdd, $destMethods)) {
									$destMethodAdd = substr($destMethodAdd, 0, -1);
								}
								if (in_array($destMethodAdd, $destMethods) && in_array($srcMethod, $destMethods) && isset($propertyData["elementType"])) {
									$newName = $this->buildNewClassName($srcClass, $destClass, $propertyData["elementType"]);
									if (class_exists($newName)) {
										foreach ($getterResult as $getterResultEntry) {
											$newCreatedObject = $this->syncObject($propertyData["elementType"], $newName, $getterResultEntry, $methodsWalkedThrough);
											$alreadyAdded = false;
											$getterResultNewObject = call_user_func(array(&$destObject, $srcMethod));
											if ($newCreatedObject->__toString() != $newName.":") {
												foreach ($getterResultNewObject as $getterResultNewObjectEntry) {
													$alreadyAdded |= ($getterResultNewObjectEntry->__toString() == $newCreatedObject->__toString());
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
										$getterResultNewObject = call_user_func(array(&$destObject, $srcMethod));
										foreach ($getterResultNewObject as $getterResultNewObjectEntry) {
											$ref = $getterResultNewObjectEntry->getReference();
											$refOrg = $ref;
											if ($ref instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
												$ref = $ref->_loadRealInstance();
											}
											if (!($ref instanceof $propertyData["elementType"]) || !in_array($refOrg->__toString(), $getterResultStrings)) {
												call_user_func(array(&$destObject, $destMethodRemove), $getterResultNewObjectEntry);
											}
										}
									}
								}
								break;
							case \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap::RELATION_HAS_ONE:
								if (in_array($destMethodSet, $destMethods)) {
									$newName = $this->buildNewClassName($srcClass, $destClass, $propertyData["type"]);
									if (class_exists($newName)) {
										$newCreatedObject = $this->syncObject($propertyData["type"], $newName, $getterResult, $methodsWalkedThrough);
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
		} else if (strlen($oldClassName) > strlen($newClassName)) {
			$buildableClassName = substr($buildableClassName, 0, strlen($newClassName)-strlen($oldClassName));
		}
		return $buildableClassName;
	}
}
?>
