<?php
namespace Querformatik\HelfenKannJeder\Controller;

class SupportMasterController
	extends AbstractOrganisationController {
	protected $supportService;
	protected $googleMapsService;
	protected $organisationTypeRepository;
	protected $supporterRepository;
	protected $organisationDraftRepository;
	protected $organisationRepository;
	protected $employeeDraftRepository;
	protected $employeeRepository;
	protected $groupDraftRepository;
	protected $groupRepository;
	protected $registerOrganisationProgressRepository;

	public function initializeAction() {
		$this->supportService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\SupportService');
		$this->googleMapsService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\GoogleMapsService');
		$this->organisationTypeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationTypeRepository');
		$this->supporterRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\SupporterRepository');
		$this->organisationDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationDraftRepository');
		$this->organisationRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');
		$this->employeeDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeDraftRepository');
		$this->employeeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeRepository');
		$this->groupDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupDraftRepository');
		$this->groupRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupRepository');
		$this->registerOrganisationProgressRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\RegisterOrganisationProgressRepository');
	}

	/**
	 * @param string $zipcode Zipcode to search for.
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType $organisationType Organisation to search for
	 */
	public function indexAction($zipcode=null, $organisationType=null) {
		$this->view->assign("zipcode", $zipcode);
		$this->view->assign("organisationTypes", $this->organisationTypeRepository->findAll());

		if ($zipcode != null && $organisationType != null) {
			$this->view->assign("organisationType", $organisationType);
			$location = $this->googleMapsService->calculateCityAndDepartment("Germany, ".$zipcode);
			$this->supportService->findSupporter($location, $this->settings["supporterGroup"], $organisationType);

			$this->view->assign("searchedGroups", $this->supportService->getSearchedGroups());
			$this->view->assign("allSupporter", $this->supportService->getAllSupporter());
		} else {
			$this->view->assign("searchedGroups", array());
			$this->view->assign("allSupporter", array());
		}
	}

	/**
	 * @param string $mail Mail to send message to.
	 */
	public function mailtestAction($mail=null) {
		if ($mail != null) {
			$mailService = $this->objectManager->get('\\Tx_QuBase_Service_MailService');
			$recipients = $mailService->send($mail, "[HKJ-WWW] Test", "Test Nachricht");
			$this->view->assign('recipients', $recipients);
		}
	}

	/**
	 */
	public function overviewAction() {
		$this->view->assign("supporters", $this->supporterRepository->findAll());
	}

	/**
	 */
	public function organisationAction() {
		$this->view->assign("organisationDrafts", $this->organisationDraftRepository->findAll());
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function diffAction($organisationDraft) {
		$this->view->assign('organisationDraft', $organisationDraft);
		$this->view->assign('employeesDraft', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisationDraft->getUid()));
		$this->view->assign('groupsDraft', $this->groupDraftRepository->findByOrganisationUid($organisationDraft->getUid()));

		$organisation = $organisationDraft->getReference();
		$this->view->assign('organisation', $organisation);
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$this->view->assign('employees', $this->employeeRepository->findByOrganisationUidWithStatement($organisation->getUid()));
			$this->view->assign('groups', $this->groupRepository->findByOrganisationUid($organisation->getUid()));
		}
	}

	/**
	 * @param string $mail Mail to get link for
	 */
	public function registerLinkAction($mail=null) {
		$registerOrganisationProgress = null;
		if ($mail != null) {
			$registerOrganisationProgresses = $this->registerOrganisationProgressRepository->findByMail($mail);
		}

		$this->view->assign('registerOrganisationProgresses', $registerOrganisationProgresses);
		$this->view->assign('mail', $mail);
	}
}
?>
