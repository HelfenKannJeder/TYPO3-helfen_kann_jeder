<?php
class Tx_HelfenKannJeder_Controller_SupportController
	extends Tx_HelfenKannJeder_Controller_AbstractOrganisationController {
	/**
	 * @var Tx_Extbase_Persistence_ManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * injectPersistenceManager
	 *
	 * @param Tx_Extbase_Persistence_ManagerInterface $persistenceManager
	 */
	public function injectPersistenceManager(Tx_Extbase_Persistence_ManagerInterface $persistenceManager) {
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

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('Tx_HelfenKannJeder_Service_AccessControlService'); // Singleton
		$this->frontendUser = $this->accessControlService->getFrontendSupporter();
		$this->organisationRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository');
		$this->organisationDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository');
		$this->logService = $this->objectManager->get('Tx_HelfenKannJeder_Service_LogService');
		$this->employeeDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeDraftRepository');
		$this->employeeRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeRepository');
		$this->groupDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupDraftRepository');
		$this->groupDraftRepository->setDefaultOrderings(array('name'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		$this->groupRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupRepository');
		$this->groupRepository->setDefaultOrderings(array('name'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		$this->mailService = $this->objectManager->get('Tx_QuBase_Service_MailService');
		$this->mailService->setFrom($this->settings["mailFrom"]);
	}

	/**
	 * @return void
	 */
	public function indexAction() {
//		$this->view->assign("organisations", $this->organisationRepository->findAll());
		$organisationDraftItems = $this->organisationDraftRepository->findBySupporterAndRequest($this->frontendUser);
		$organisationDraftItems = $organisationDraftItems->toArray();
		usort($organisationDraftItems, array(&$this, "sortOrganisationDraftByRequest"));
		$this->view->assign("organisationDrafts", $organisationDraftItems);
		//$this->view->assign("organisationDrafts", $this->organisationDraftRepository->findBySupporterAndRequest($this->frontendUser));
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

			if (!($destObject instanceof $destClass) && !($destObject instanceof Tx_Extbase_Persistence_LazyLoadingProxy && $destObject->getUid() != 0)) {
				$destObject = new $destClass();
				$destObject->setReference($srcObject);
				$srcObject->setReference($destObject);
			}

			$srcMethods = get_class_methods($srcClass);
			$destMethods = get_class_methods($destClass);

			$dataMapper = $this->objectManager->get('Tx_Extbase_Persistence_Mapper_DataMapper');
			$reflectionService = $this->objectManager->get('Tx_Extbase_Reflection_Service');

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

					if ($columnMap instanceof Tx_Extbase_Persistence_Mapper_ColumnMap) {
						$getterResult = call_user_func(array(&$srcObject, $srcMethod));
						switch ($columnMap->getTypeOfRelation()) {
							case Tx_Extbase_Persistence_Mapper_ColumnMap::RELATION_HAS_MANY:
							case Tx_Extbase_Persistence_Mapper_ColumnMap::RELATION_HAS_AND_BELONGS_TO_MANY:
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
												if ($newCreatedObject instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
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
											if ($ref instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
												$ref = $ref->_loadRealInstance();
											}
											if (!($ref instanceof $propertyData["elementType"]) || !in_array($refOrg->__toString(), $getterResultStrings)) {
												call_user_func(array(&$destObject, $destMethodRemove), $getterResultNewObjectEntry);
											}
										}
									}
								}
								break;
							case Tx_Extbase_Persistence_Mapper_ColumnMap::RELATION_HAS_ONE:
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
							case Tx_Extbase_Persistence_Mapper_ColumnMap::RELATION_BELONGS_TO_MANY:
								break;
							case Tx_Extbase_Persistence_Mapper_ColumnMap::RELATION_NONE:
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
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisationDraft
	 */
	public function test2liveAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		$organisationDraft->setRequest(2);
		$organisationDraft->setRequesttime(time());
		$destObject = $this->syncObject("Tx_HelfenKannJeder_Domain_Model_OrganisationDraft", "Tx_HelfenKannJeder_Domain_Model_Organisation", $organisationDraft);
		$this->organisationDraftRepository->update($organisationDraft);
		if ($organisationDraft->getFeuser()->getEmail() != "") {
			$mailHeadline = Tx_Extbase_Utility_Localization::translate('mail.organisation.requestSucceed.headline', 'HelfenKannJeder');
			$mailContent = sprintf(Tx_Extbase_Utility_Localization::translate('mail.organisation.requestSucceed.content', 'HelfenKannJeder'), $organisationDraft->getFeuser()->getFirstName());
			$this->mailService->send($organisationDraft->getFeuser()->getEmail(), $mailHeadline, $mailContent);
			$this->mailService->send("valentin.zickner@helfenkannjeder.de", $mailHeadline, $mailContent); // TODO: Maybe this should specified in the settings.
		}
		$this->logService->insert("The organisation was send to live.", $organisationDraft);
		$this->persistenceManager->persistAll();

		// TODO: Prove TYPO3 6.0 compatiblity
		$tce = t3lib_div::makeInstance('t3lib_TCEmain');
		$tce->clear_cacheCmd(7);  // TODO: Load by typoscript, ID of the page for which to clear the cache
		$tce->clear_cacheCmd(9);
		$this->redirect("index");
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Organisation $organisation
	 */
	public function live2testAction($organisation) {
/*		$destObject = $this->syncObject("Tx_HelfenKannJeder_Domain_Model_Organisation", "Tx_HelfenKannJeder_Domain_Model_OrganisationDraft", &$organisation);
		$this->organisationRepository->update($organisation);
		$this->persistenceManager->persistAll();
		$this->logService->insert("The organisation was recopied to workspace.", $organisation->getReference());*/
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisationDraft
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
		if ($organisation instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$organisation = $organisation->_loadRealInstance();
		}
		$this->view->assign('organisation', $organisation);
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_Organisation) {
			$this->view->assign('employees', $this->employeeRepository->findByOrganisationUidWithStatement($organisation->getUid()));
			$this->view->assign('groups', $this->groupRepository->findByOrganisationUid($organisation->getUid()));
		}
/*		$organisationDiff = new Tx_HelfenKannJeder_Domain_Model_OrganisationDraft();
		$organisationDiff->setName("<span style='color:red'>test</span>");
		$this->view->assign('organisationDiff', $organisationDiff);*/
//		$this->view->assign('employeesDiff', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisationDraft->getUid()));
//		$this->view->assign('groupsDiff', $this->groupDraftRepository->findByOrganisationUid($organisationDraft->getUid()));
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisationDraft
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
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisationDraft
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
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisationDraft
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
			$mailHeadline = Tx_Extbase_Utility_Localization::translate('mail.organisation.requestDeny.headline', 'HelfenKannJeder');
			$mailContent = sprintf(Tx_Extbase_Utility_Localization::translate('mail.organisation.requestDeny.content', 'HelfenKannJeder'), $organisationDraft->getFeuser()->getFirstName());
			$this->mailService->send($organisationDraft->getFeuser()->getEmail(), $mailHeadline, $mailContent);
		}

		$this->logService->insert("The organisation was not published by the supporter.", $organisationDraft);
		$this->redirect("write", "Message", "QuMessaging", array("writeTo" => $organisationDraft->getFeuser()), $this->settings["page"]["messaging"]);
	}
}
?>
