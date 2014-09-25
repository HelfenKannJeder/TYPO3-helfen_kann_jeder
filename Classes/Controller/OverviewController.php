<?php
namespace Querformatik\HelfenKannJeder\Controller;

class OverviewController
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	protected $organisationRepository;
	protected $employeeRepository;
	protected $groupRepository;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');
		$this->organisationRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));

		$this->employeeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeRepository');
		$this->groupRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupRepository');
	}

	/**
	 * @return void
	 */
	public function indexAction() {
		$age = 18;
		$latitude = 0;
		$longitude = 0;
		if (isset($_COOKIE["hkj_info"])) {
			$informations = explode("##1##",$_COOKIE["hkj_info"]);
			$latitude = (float)$informations[0];
			$longitude = (float)$informations[1];
			$age = (int)$informations[4];
		}
		if ($age == 0) $age = 18;
		if ($latitude == 0 || $longitude == 0) {
			$organisations = $this->organisationRepository->findByIsDummy(1);
			$count = count($organisations);
		} else {
			$organisations = $this->organisationRepository->findNearLatLngExecute($latitude, $longitude, $age);
 			$count = $this->organisationRepository->findNearLatLngCount($latitude, $longitude, $age);
		}
		$this->view->assign('organisations', $organisations);
		$this->view->assign('organisationsCount', $count);
		$this->view->assign('city', $city);
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
?>
