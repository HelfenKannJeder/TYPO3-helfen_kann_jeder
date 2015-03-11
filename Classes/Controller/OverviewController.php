<?php
namespace Querformatik\HelfenKannJeder\Controller;

/**
 * Overview over organisations in the near of the user or all dummy
 * organisations.
 *
 * @author Valentin Zickner
 */
class OverviewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationRepository
	 * @inject
	 */
	protected $organisationRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\EmployeeRepository
	 * @inject
	 */
	protected $employeeRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\GroupRepository
	 * @inject
	 */
	protected $groupRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\CookieService
	 * @inject
	 */
	protected $cookieService;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\GoogleMapsService
	 * @inject
	 */
	protected $googleMapsService;

	/**
	 * @return void
	 */
	public function indexAction() {
		list($latitude, $longitude) = $this->cookieService->getPersonalCookie();

		if ($latitude == 0 || $longitude == 0) {
			$organisations = $this->organisationRepository->findByIsDummy(1);
		} else {
			$organisations = $this->organisationRepository->findOrganisationNearLocation($latitude, $longitude, FALSE)->toArray();
			$organisations = $this->googleMapsService->filterByDistance($organisations, $latitude, $longitude,
				$this->settings['config']['maxDistance']);
			$organisations = $this->googleMapsService->sortByDistance($organisations, $latitude, $longitude);
		}
		$this->view->assign('organisations', $organisations);
		$this->view->assign('latitude', $latitude);
		$this->view->assign('longitude', $longitude);
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation
	 * @return void
	 */
	public function detailAction(\Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation) {
		$this->view->assign('organisation', $organisation);
		$this->view->assign('employees', $this->employeeRepository->findByOrganisationUidWithStatement($organisation->getUid()));
		$this->view->assign('groups', $this->groupRepository->findByOrganisationUid($organisation->getUid()));
	}
}
