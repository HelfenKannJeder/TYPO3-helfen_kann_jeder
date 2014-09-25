<?php
namespace Querformatik\HelfenKannJeder\Controller;

class OrganisationController extends AbstractOrganisationController {
	/**
	 * organisationDraftRepository
	 *
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 */
	protected $organisationDraftRepository;

	/**
	 * injectOrganisationDraftRepository
	 *
	 * @param \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository $organisationDraftRepository
	 * @return void
	 */
	public function injectOrganisationDraftRepository(\Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository $organisationDraftRepository) {
		$this->organisationDraftRepository = $organisationDraftRepository;
	}

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
		$this->accessControlService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService'); // Singleton

		$this->registerOrganisationProgressRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\RegisterOrganisationProgressRepository');
		$this->registerOrganisationProgress = $this->registerOrganisationProgressRepository->findByCurrentSession($this->accessControlService->getSessionId(),1800);

		$this->matrixService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\MatrixService');

		$this->organisationTypeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationTypeRepository');
		$this->groupDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupDraftRepository');

		$this->employeeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeRepository');
		$this->employeeDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeDraftRepository');

		$this->frontendUserRepository = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
		$this->frontendUserGroupRepository = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserGroupRepository');
		$this->frontendUser = $this->accessControlService->getFrontendUser();

		$this->activityRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\ActivityRepository');
		$this->activityfieldRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\ActivityFieldRepository');

		$this->googleMapsService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\GoogleMapsService');
		$this->googleMapsService->setGoogleServer($this->settings["googleMapsServer"]);
		$this->googleMapsService->setGoogleApiKey($this->settings["googleMapsApiKey"]);

		$this->mailService = $this->objectManager->get('\\Tx_QuBase_Service_MailService');
		$this->mailService->setFrom($this->settings["mailFrom"]);
		$this->logService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\LogService');

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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation The organisation to show
	 * @return void
	 */
	public function showAction(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation) {
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function generalAction(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation, $errorFields = array()) {
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation The organisation to show
	 * @ignorevalidation $organisation
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function generalSendAction(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation) {
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function workinghourAction(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation, $errorFields = array()) {
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function groupAction(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation, $errorFields = array()) {
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation The organisation to show
	 * @param array $errorFields Error fields from the save action.
	 * @return void
	 */
	public function pictureAction(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation, $errorFields = array()) {
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
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
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
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
				if ($supporter instanceof \Querformatik\HelfenKannJeder\Domain\Model\Supporter && $supporter->getEmail() != "") {
					$mailHeadline = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.supporter.afterRequest.headline', 'HelfenKannJeder'), $organisation->getName());
					$mailContent = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.supporter.afterRequest.content', 'HelfenKannJeder'), $supporter->getFirstName(), $organisation->getName());
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
			if ($supporter instanceof \Querformatik\HelfenKannJeder\Domain\Model\Supporter && $supporter->getEmail() != "") {
				$mailHeadline = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.supporter.removedRequest.headline', 'HelfenKannJeder'), $organisation->getName());
				$mailContent = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.supporter.removedRequest.content', 'HelfenKannJeder'), $supporter->getFirstName(), $organisation->getName());
				$this->mailService->send($supporter->getEmail(), $mailHeadline, $mailContent);
			}
			$this->logService->insert("The organisation removed a publishing request.", $organisation);
		}

		$this->organisationDraftRepository->update($organisation);

		$this->redirect("show", NULL, NULL, array('organisation' => $organisation));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
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
			if (!($activity instanceof \Querformatik\HelfenKannJeder\Domain\Model\Activity) || !in_array($activity->getUid(), $activityList)) {
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
