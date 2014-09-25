<?php
namespace Querformatik\HelfenKannJeder\Controller;

class SupportController
	extends AbstractOrganisationController {
	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * injectPersistenceManager
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager
	 */
	public function injectPersistenceManager(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}

	protected $accessControlService;
	protected $frontendUser;
	protected $organisationRepository;
	protected $organisationDraftRepository;
	protected $logService;
	protected $employeeDraftRepository;
	protected $employeeRepository;
	protected $groupDraftRepository;
	protected $groupRepository;
	protected $mailService;

	/**
	 * @var Etobi\CoreAPI\Service\CacheApiService
	 * @inject
	 */
	protected $cacheApiService;

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService'); // Singleton
		$this->frontendUser = $this->accessControlService->getFrontendSupporter();
		$this->organisationRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');
		$this->organisationDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationDraftRepository');
		$this->logService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\LogService');
		$this->employeeDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeDraftRepository');
		$this->employeeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeRepository');
		$this->groupDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupDraftRepository');
		$this->groupDraftRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		$this->groupRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupRepository');
		$this->groupRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		$this->mailService = $this->objectManager->get('\\Tx_QuBase_Service_MailService');
		$this->mailService->setFrom($this->settings["mailFrom"]);
	}

	/**
	 * @return void
	 */
	public function indexAction() {
		$organisationDraftItems = $this->organisationDraftRepository->findBySupporterAndRequest($this->frontendUser);
		$organisationDraftItems = $organisationDraftItems->toArray();
		usort($organisationDraftItems, array(&$this, "sortOrganisationDraftByRequest"));
		$this->view->assign("organisationDrafts", $organisationDraftItems);
	}

	protected function sortOrganisationDraftByRequest($a, $b) {
		$requestList = array(2, 3, 1, 4);
		if ($a->getRequest() == $b->getRequest()) {
			return $a->getRequesttime() > $b->getRequesttime();
		}

		return ($requestList[$a->getRequest()] < $requestList[$b->getRequest()]);
	}

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

			$dataMapper = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMapper');
			$reflectionService = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Reflection\\ReflectionService');

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

	protected function buildNewClassName($oldClassName, $newClassName, $buildableClassName) {
		if (strlen($oldClassName) < strlen($newClassName)) {
			$buildableClassName .= substr($newClassName, strlen($oldClassName));
		} else if (strlen($oldClassName) > strlen($newClassName)) {
			$buildableClassName = substr($buildableClassName, 0, strlen($newClassName)-strlen($oldClassName));
		}
		return $buildableClassName;
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function test2liveAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		$organisationDraft->setRequest(2);
		$organisationDraft->setRequesttime(time());
		$destObject = $this->syncObject("\\Querformatik\\HelfenKannJeder\\Domain\\Model\\OrganisationDraft", "\\Querformatik\\HelfenKannJeder\\Domain\\Model\\Organisation", $organisationDraft);
		$this->organisationDraftRepository->update($organisationDraft);
		if ($organisationDraft->getFeuser()->getEmail() != "") {
			$mailHeadline = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestSucceed.headline', 'HelfenKannJeder');
			$mailContent = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestSucceed.content', 'HelfenKannJeder'), $organisationDraft->getFeuser()->getFirstName());
			$this->mailService->send($organisationDraft->getFeuser()->getEmail(), $mailHeadline, $mailContent);
			$this->mailService->send("valentin.zickner@helfenkannjeder.de", $mailHeadline, $mailContent); // TODO: Maybe this should specified in the settings.
		}
		$this->logService->insert("The organisation was send to live.", $organisationDraft);
		$this->persistenceManager->persistAll();

		$this->cacheApiService->clearPageCache(); // TODO: Is this enouth?: https://github.com/TYPO3-coreapi/ext-coreapi/blob/master/Classes/Service/CacheApiService.php
		$this->redirect("index");
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation
	 */
	public function live2testAction($organisation) {
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function diffAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		if ($organisationDraft->getRequest() == 1 || $organisationDraft->getRequest() == 3) {
			$organisationDraft->setRequest(3);
			$organisationDraft->setRequesttime(time());
			$this->organisationDraftRepository->update($organisationDraft);
			$this->logService->insert("The organisation was locked by supporter (visit diff).", $organisationDraft);
		}

		$this->view->assign('organisationDraft', $organisationDraft);
		$this->view->assign('employeesDraft', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisationDraft->getUid()));
		$this->view->assign('groupsDraft', $this->groupDraftRepository->findByOrganisationUid($organisationDraft->getUid()));

		$organisation = $organisationDraft->getReference();
		if ($organisation instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$organisation = $organisation->_loadRealInstance();
		}
		$this->view->assign('organisation', $organisation);
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$this->view->assign('employees', $this->employeeRepository->findByOrganisationUidWithStatement($organisation->getUid()));
			$this->view->assign('groups', $this->groupRepository->findByOrganisationUid($organisation->getUid()));
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function viewAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		if ($organisationDraft->getRequest() == 1 || $organisationDraft->getRequest() == 3) {
			$organisationDraft->setRequest(3);
			$organisationDraft->setRequesttime(time());
			$this->organisationDraftRepository->update($organisationDraft);
			$this->logService->insert("The organisation was locked by supporter (visit view).", $organisationDraft);
		}

		$this->view->assign('organisationDraft', $organisationDraft);
		$this->view->assign('employeesDraft', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisationDraft->getUid()));
		$this->view->assign('groupsDraft', $this->groupDraftRepository->findByOrganisationUid($organisationDraft->getUid()));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function backAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		$organisationDraft->setRequest(1);
		$organisationDraft->setRequesttime(time());
		$this->organisationDraftRepository->update($organisationDraft);
		$this->logService->insert("The organisation was unlocked by supporter.", $organisationDraft);
		$this->redirect("index");
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function denyAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		$organisationDraft->setRequest(0);
		$organisationDraft->setRequesttime(time());
		$this->organisationDraftRepository->update($organisationDraft);

		if ($organisationDraft->getFeuser()->getEmail() != "") {
			$mailHeadline = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestDeny.headline', 'HelfenKannJeder');
			$mailContent = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestDeny.content', 'HelfenKannJeder'), $organisationDraft->getFeuser()->getFirstName());
			$this->mailService->send($organisationDraft->getFeuser()->getEmail(), $mailHeadline, $mailContent);
		}

		$this->logService->insert("The organisation was not published by the supporter.", $organisationDraft);
		$this->redirect("write", "Message", "QuMessaging", array("writeTo" => $organisationDraft->getFeuser()), $this->settings["page"]["messaging"]);
	}
}
?>
