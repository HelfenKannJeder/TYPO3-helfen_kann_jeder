<?php
class Tx_HelfenKannJeder_Controller_OrganisationController
	extends Tx_HelfenKannJeder_Controller_AbstractOrganisationController {
	/**
	 * organisationDraftRepository
	 *
	 * @var Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository
	 */
	protected $organisationDraftRepository;

	/**
	 * injectOrganisationDraftRepository
	 *
	 * @param Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository $organisationDraftRepository
	 * @return void
	 */
	public function injectOrganisationDraftRepository(Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository $organisationDraftRepository) {
		$this->organisationDraftRepository = $organisationDraftRepository;
	}

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
	protected $registerOrganisationProgressRepository;
	protected $registerOrganisationProgress;
	protected $matrixService;
	protected $organisationTypeRepository;
	protected $groupDraftRepository;
	protected $employeeRepository;
	protected $employeeDraftRepository;
	protected $frontendUserRepository;
	protected $frontendUserGroupRepository;
	protected $frontendUser;
	protected $activityRepository;
	protected $activityfieldRepository;
	protected $googleMapsService;
	protected $mailService;
	protected $stepBackWithoutSave;
	protected $stepBack;
	protected $organisations;
	protected $organisationUids;

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('Tx_HelfenKannJeder_Service_AccessControlService'); // Singleton

		$this->registerOrganisationProgressRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_RegisterOrganisationProgressRepository');
		$this->registerOrganisationProgress = $this->registerOrganisationProgressRepository->findByCurrentSession($this->accessControlService->getSessionId(),1800);

		$this->matrixService = $this->objectManager->get('Tx_HelfenKannJeder_Service_MatrixService');

		$this->organisationTypeRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationTypeRepository');
		$this->groupDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupDraftRepository');

		$this->employeeRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeRepository');
		$this->employeeDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeDraftRepository');

		$this->frontendUserRepository = $this->objectManager->get('Tx_Extbase_Domain_Repository_FrontendUserRepository');
		$this->frontendUserGroupRepository = $this->objectManager->get('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
		$this->frontendUser = $this->accessControlService->getFrontendUser();

		$this->activityRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_ActivityRepository');
		$this->activityfieldRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_ActivityFieldRepository');

		$this->googleMapsService = $this->objectManager->get('Tx_HelfenKannJeder_Service_GoogleMapsService');
		$this->googleMapsService->setGoogleServer($this->settings["googleMapsServer"]);
		$this->googleMapsService->setGoogleApiKey($this->settings["googleMapsApiKey"]);

		$this->mailService = $this->objectManager->get('Tx_QuBase_Service_MailService');
		$this->mailService->setFrom($this->settings["mailFrom"]);
		$this->logService = $this->objectManager->get('Tx_HelfenKannJeder_Service_LogService');

		$this->organisationUids = array();
		$this->organisations = $this->organisationDraftRepository->findByFeuser($this->frontendUser->getUid());
		if (count($this->organisations) == 0) {
			$this->organisations = $this->organisationDraftRepository->findBySupporter($this->frontendUser->getUid());
		}

		foreach ($this->organisations as $organisation) {
			$this->organisationUids[] = $organisation->getUid();
		}

		if ($this->request->hasArgument("stepBackWithoutSave")) {
			$this->stepBackWithoutSave = true;
		}

		if ($this->request->hasArgument("stepBack")) {
			$this->stepBack = true;
		}
	}

	public function indexAction() {
		if (count($this->organisations) == 1) {
			$this->redirect("show",'Organisation',Null,array('organisation' => $this->organisations->getFirst()));
		}
		$this->view->assign("organisations", $organisations);
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation The organisation to show
	 * @return void
	 */
	public function showAction(Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		$this->flashMessageContainer->flush();
		$flashMessages = array();
		$this->callValidator('OrganisationInformation', $organisation);
		$flashMessages["OrganisationInformation"] = array("general", $this->flashMessageContainer->getAllMessagesAndFlush(), $this->getErrorFieldsAndClear());
		$this->callValidator('OrganisationAddress', $organisation, '', $this->frontendUser->getZip());
		$flashMessages["OrganisationAddress"] = array("general", $this->flashMessageContainer->getAllMessagesAndFlush(), $this->getErrorFieldsAndClear());
		$this->callValidator('OrganisationEmployee', $organisation);
		$flashMessages["OrganisationEmployee"] = array("general", $this->flashMessageContainer->getAllMessagesAndFlush(), $this->getErrorFieldsAndClear());
		$this->callValidator('OrganisationContactperson', $organisation);
		$flashMessages["OrganisationContactperson"] = array("general", $this->flashMessageContainer->getAllMessagesAndFlush(), $this->getErrorFieldsAndClear());
		$this->callValidator('OrganisationGroup', $organisation);
		$flashMessages["OrganisationGroup"] = array("group", $this->flashMessageContainer->getAllMessagesAndFlush(), $this->getErrorFieldsAndClear());
		$this->callValidator('OrganisationWorkinghour', $organisation);
		$flashMessages["OrganisationWorkinghour"] = array("workinghour", $this->flashMessageContainer->getAllMessagesAndFlush(), $this->getErrorFieldsAndClear());
		$this->callValidator('OrganisationPicture', $organisation, '', $this->imageFolder);
		$flashMessages["OrganisationPicture"] = array("picture", $this->flashMessageContainer->getAllMessagesAndFlush(), $this->getErrorFieldsAndClear());



		$this->view->assign('args', array('organisation' => $organisation));
		$this->view->assign("editLink", array(
			'general' => 'general',
			'picture' => 'picture',
			'matrix' => 'matrix',
			'workinghour' => 'workinghour',
			'group' => 'group',
		));
		$this->view->assign('organisation', $organisation);
		$this->view->assign('groups', $this->groupDraftRepository->findByOrganisationUid($organisation->getUid()));
		$this->view->assign('employees', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisation->getUid()));
		$this->view->assign("has_errors", $this->hasErrors());
		$this->view->assign("imageFolder", $this->imageFolder);
		$this->view->assign("flashMessages", $flashMessages);
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function generalAction(Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation, $errorFields = array()) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		$this->view->assign("organisation", $organisation);
		$this->view->assign("frontendUser", $this->frontendUser);
		$this->view->assign("has_errors", $this->hasErrors());
		$this->view->assign("errorFields", $errorFields);
		$this->view->assign("showMap", 1);
	}

	/**
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function initializeGeneralSendAction() {
		$this->initializeStoreGeneral();
		$this->initializeStoreAddresses();
		$this->initializeStoreEmployees();
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation The organisation to show
	 * @ignorevalidation $organisation
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function generalSendAction(Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		if ($this->stepBackWithoutSave == true) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
			return;
		}
		if ($this->restoreRequestTime($organisation)->getRequest() != 0)
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));

		$this->organisationDraftRepository->update($organisation);
		$this->storeGeneral($organisation);
		$this->storeAddresses($organisation);
		$this->storeEmployees($organisation);
		$this->persistenceManager->persistAll();

		$this->callValidator('OrganisationInformation', $organisation);
		$this->callValidator('OrganisationAddress', $organisation, '', $this->frontendUser->getZip());
		$this->callValidator('OrganisationEmployee', $organisation);
		$this->callValidator('OrganisationContactperson', $organisation);

		if ($this->stepBack == true && !$this->hasErrors()) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
		} else {
			$this->redirect("general", NULL, NULL, array('organisation' => $organisation, 'errorFields' => $this->getErrorFields()));
		}
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function workinghourAction(Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation, $errorFields = array()) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		$this->view->assign("organisation", $organisation);
		$this->view->assign("frontendUser", $this->frontendUser);
		$this->view->assign("has_errors", $this->hasErrors());
		$this->view->assign("errorFields", $errorFields);
		$this->view->assign("showMap", 1);
	}

	/**
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function initializeWorkinghourSendAction() {
		$this->initializeStoreWorkinghours();
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 * @ignorevalidation $organisation
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function workinghourSendAction($organisation) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		if ($this->stepBackWithoutSave == true) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
			return;
		}
		if ($this->restoreRequestTime($organisation)->getRequest() != 0)
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));

		$this->storeWorkinghours($organisation);

		$this->callValidator('OrganisationWorkinghour', $organisation);

		if ($this->stepBack == true && !$this->hasErrors()) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
		} else {
			$this->redirect("workinghour", NULL, NULL, array('organisation' => $organisation, 'errorFields' => $this->getErrorFields()));
		}
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function groupAction(Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation, $errorFields = array()) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		$groupListByTemplate = $this->groupDraftRepository->findByOrganisationGroupListByTemplate($organisation);

		$this->view->assign("groups", $groupListByTemplate);
		$this->view->assign("groupsCount", count($groupListByTemplate));
		$this->view->assign("organisation", $organisation);
		$this->view->assign("frontendUser", $this->frontendUser);
		$this->view->assign("has_errors", $this->hasErrors());
		$this->view->assign("errorFields", $errorFields);
		$this->view->assign("showMap", 1);
	}

	/**
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function initializeGroupSendAction() {
		$this->initializeStoreGroups();
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 * @ignorevalidation $organisation
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function groupSendAction($organisation) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		if ($this->stepBackWithoutSave == true) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
			return;
		}
		if ($this->restoreRequestTime($organisation)->getRequest() != 0)
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));

		$this->storeGroups($organisation);
		$this->persistenceManager->persistAll();

		$this->callValidator('OrganisationGroup', $organisation);

		if ($this->stepBack == true && !$this->hasErrors()) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
		} else {
			$this->redirect("group", NULL, NULL, array('organisation' => $organisation, 'errorFields' => $this->getErrorFields()));
		}
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function pictureAction(Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation, $errorFields = array()) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		$organisation->setHash($this->accessControlService->getSessionId());
		$this->organisationDraftRepository->update($organisation);

		$this->view->assign("organisation", $organisation);
		$this->view->assign("frontendUser", $this->frontendUser);
		$this->view->assign("has_errors", $this->hasErrors());
		$this->view->assign("errorFields", $errorFields);
		$this->view->assign("showMap", 1);
		$this->view->assign("sessionid", $this->accessControlService->getSessionId());
		$this->view->assign("imageFolder", $this->imageFolder);
		$this->view->assign("internetexplorer", $this->getBrowser() == "ie");
		$this->view->assign("uploadPageUid", $this->settings["registerOrganisationStepsPart2"]);
	}

	/**
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function initializePictureSendAction() {
		$this->initializeStorePictures($organisation);
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function pictureSendAction($organisation) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		if ($this->stepBackWithoutSave == true) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
			return;
		}
		if ($this->restoreRequestTime($organisation)->getRequest() != 0)
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));

		$this->storePictures($organisation);

		$this->callValidator('OrganisationPicture', $organisation, '', $this->imageFolder);

		if ($this->stepBack == true && !$this->hasErrors()) {
			$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
		} else {
			$this->redirect("picture", NULL, NULL, array('organisation' => $organisation, 'errorFields' => $this->getErrorFields()));
		}
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 * @param integer $newStatus
	 * @return void
	 */
	public function statusChangeAction($organisation, $newStatus) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		if ($organisation->getRequest() == 0 && $newStatus == 1) {
			$this->callValidator('OrganisationInformation', $organisation);
			$this->callValidator('OrganisationAddress', $organisation, '', $this->frontendUser->getZip());
			$this->callValidator('OrganisationEmployee', $organisation);
			$this->callValidator('OrganisationContactperson', $organisation);
			$this->callValidator('OrganisationGroup', $organisation);
			$this->callValidator('OrganisationWorkinghour', $organisation);
			$this->callValidator('OrganisationPicture', $organisation, '', $this->imageFolder);

			if (!$this->hasErrors()) {
				$organisation->setRequest($newStatus);
				$organisation->setRequesttime(time());

				$supporter = $organisation->getSupporter();
				if ($supporter instanceof Tx_HelfenKannJeder_Domain_Model_Supporter && $supporter->getEmail() != "") {
					$mailHeadline = sprintf(Tx_Extbase_Utility_Localization::translate('mail.supporter.afterRequest.headline', 'HelfenKannJeder'), $organisation->getName());
					$mailContent = sprintf(Tx_Extbase_Utility_Localization::translate('mail.supporter.afterRequest.content', 'HelfenKannJeder'), $supporter->getFirstName(), $organisation->getName());
					$this->mailService->send($supporter->getEmail(), $mailHeadline, $mailContent);
				}
				$this->logService->insert("The organisation added a publishing request.", $organisation);
			}
		}
		$sendmail = false;
		if ($organisation->getRequest() == 1 && $newStatus == 0) {
			$organisation->setRequest($newStatus);
			$organisation->setRequesttime(time());
			$sendmail = true;
		}
		if ($organisation->getRequest() == 2 && $newStatus == 0) {
			$organisation->setRequest($newStatus);
			$organisation->setRequesttime(time());
		}

		if ($sendmail) {
			$supporter = $organisation->getSupporter();
			if ($supporter instanceof Tx_HelfenKannJeder_Domain_Model_Supporter && $supporter->getEmail() != "") {
				$mailHeadline = sprintf(Tx_Extbase_Utility_Localization::translate('mail.supporter.removedRequest.headline', 'HelfenKannJeder'), $organisation->getName());
				$mailContent = sprintf(Tx_Extbase_Utility_Localization::translate('mail.supporter.removedRequest.content', 'HelfenKannJeder'), $supporter->getFirstName(), $organisation->getName());
				$this->mailService->send($supporter->getEmail(), $mailHeadline, $mailContent);
			}
			$this->logService->insert("The organisation removed a publishing request.", $organisation);
		}

		$this->organisationDraftRepository->update($organisation);

		$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function matrixAction($organisation) {
		if (!in_array($organisation->getUid(), $this->organisationUids)) {
			$this->redirect('index'); return;
		}

		$activities = $this->activityRepository->findAll();
		$activityfields = $this->activityfieldRepository->findAll();
		$this->view->assign('activityfields', $activityfields);
		$this->view->assign('organisation', $organisation);

		$this->matrixService->buildOrganisationMatrix($organisation);
		$matrixA = $this->matrixService->getMatrix();
		$activityList = $this->matrixService->getActivityList();

		$activityList = array_unique($activityList);

		$activities = $activities->toArray();
		foreach ($activities as $key => $activity) {
			if (!($activity instanceof Tx_HelfenKannJeder_Domain_Model_Activity) || !in_array($activity->getUid(), $activityList)) {
//				echo "ok";
				unset($activities[$key]);
			}
		}
		$this->view->assign('activities', $activities);

		$this->view->assign('matrixarray', $matrixA);
		$this->view->assign('activityList', array_unique($activityList));
		$this->view->assign("step", 81);
		$this->view->assign("actionSendMethod", "showstep80");
		$this->view->assign("headline", "register_step81_headline");
		$this->view->assign("objectEditName", "organisation");
		$this->view->assign("objectEdit", $organisation);
		$this->view->assign("registerOrganisationProgress", $registerOrganisationProgress);
		$this->view->assign("args", array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign("frontendUser", $this->frontendUser);
		$this->view->assign("imageFolder", $this->imageFolder);
		$this->view->assign('employees', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisation->getUid()));
		$this->view->assign('groups', $this->groupDraftRepository->findByOrganisationUid($organisation->getUid()));
	}

}
?>
