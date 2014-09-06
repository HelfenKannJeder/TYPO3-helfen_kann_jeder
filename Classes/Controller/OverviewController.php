<?php
class Tx_HelfenKannJeder_Controller_OverviewController
	extends Tx_Extbase_MVC_Controller_ActionController {
	protected $organisationRepository;
	protected $employeeRepository;
	protected $groupRepository;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository');
		$this->organisationRepository->setDefaultOrderings(array('name'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));

		$this->employeeRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeRepository');
		$this->groupRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupRepository');
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
//		$this->view->assign('organisations', $this->organisationRepository->findAll());
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Organisation $organisation
	 * @return void
	 */
	public function detailAction(Tx_HelfenKannJeder_Domain_Model_Organisation $organisation) {
		$this->view->assign('organisation', $organisation);
		$this->view->assign('employees', $this->employeeRepository->findByOrganisationUidWithStatement($organisation->getUid()));
		$this->view->assign('groups', $this->groupRepository->findByOrganisationUid($organisation->getUid()));
	}
}
?>
