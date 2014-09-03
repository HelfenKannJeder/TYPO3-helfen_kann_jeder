<?php
class Tx_HelfenKannJeder_Controller_GroupController
	extends Tx_Extbase_MVC_Controller_ActionController {
	protected $accessControlService;
	protected $googleMapsService;
	protected $groupRepository;
	protected $matrixRepository;

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('Tx_HelfenKannJeder_Service_AccessControlService');
		$this->googleMapsService = $this->objectManager->get('Tx_HelfenKannJeder_Service_GoogleMapsService');
		$this->googleMapsService->setGoogleServer($this->settings["googleMapsServer"]);
		$this->googleMapsService->setGoogleApiKey($this->settings["googleMapsApiKey"]);

		$this->groupRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupRepository');
		$this->matrixRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_MatrixRepository');
	}

	public function indexAction() {
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Organisation $organisation The organisation to add the group to
	 * @param Tx_HelfenKannJeder_Domain_Model_Group $newGroup A fresh group object taken as a basis for the rendering
	 * @return void
	 * @ignorevalidation $newGroup
	 */
	public function newAction(Tx_HelfenKannJeder_Domain_Model_Organisation $organisation, Tx_HelfenKannJeder_Domain_Model_Group $newGroup = null) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_Organisation
			&& $this->accessControlService->isLoggedIn($organisation->getFeuser())) {

			if ($newGroup == null) {
				$newGroup = new Tx_HelfenKannJeder_Domain_Model_Group();
			}

			if ($newGroup->getStreet() == "" && $newGroup->getZipcode() == "" && $newGroup->getCity() == "" && $newGroup->getWebsite() == "") {
				$newGroup->setStreet($organisation->getStreet());
				$newGroup->setZipcode($organisation->getZipcode());
				$newGroup->setCity($organisation->getCity());
				$newGroup->setWebsite($organisation->getWebsite());
			}


			$this->view->assign('organisation', $organisation);
			$this->view->assign('newGroup', $newGroup);
			$this->view->assign('matrices', $this->matrixRepository->findByOrganisation($organisation));
		} else {
			// wrong user or not logged in.
			$this->redirect('index', 'Organisation', NULL, array());
		}
	}

	/**
	 * Create a new group
	 *
	 * @param Tx_HelfenKannJeder_Domain_Model_Organisation $organisation The organisation to add the group to
	 * @param Tx_HelfenKannJeder_Domain_Model_Group $newGroup A fresh group object which has not yet been added to repository
	 * @return void
	 */
	public function createAction(Tx_HelfenKannJeder_Domain_Model_Organisation $organisation, Tx_HelfenKannJeder_Domain_Model_Group $newGroup) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_Organisation
			&& $this->accessControlService->isLoggedIn($organisation->getFeuser())) {

			// Calculate latitude and longitude
			if ($newGroup->getAddress() != "") {
				$latlng = $this->googleMapsService->calculateLatitudeLongitude($newGroup->getAddress());
				if (is_array($latlng) && count($latlng) == 2) {
					$newGroup->setLatitude($latlng[0]);
					$newGroup->setLongitude($latlng[1]);
				}
			}
			$organisation->addGroup($newGroup);
			$newGroup->setOrganisation($organisation);
			$this->redirect('show', 'Organisation', NULL, array('organisation' => $organisation));
		} else {
			// wrong user or not logged in.
			$this->redirect('index', 'Organisation', NULL, array());
		}
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Group $group The group to edit
	 * @ignorevalidation $group
	 * @return void
	 */
	public function editAction(Tx_HelfenKannJeder_Domain_Model_Group $group) { // prove rights
		if ($group instanceof Tx_HelfenKannJeder_Domain_Model_Group
			&& $group->getOrganisation() instanceof Tx_HelfenKannJeder_Domain_Model_Organisation
			&& $this->accessControlService->isLoggedIn($group->getOrganisation()->getFeuser())) {
			$this->view->assign('matrices', $this->matrixRepository->findByOrganisation($group->getOrganisation()));
			$this->view->assign('group', $group);
		} else {
			// wrong user or not logged in.
			$this->redirect('index', 'Organisation', NULL, array());
		}
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Group $group The modified group
	 * @return void
	 */
	public function updateAction(Tx_HelfenKannJeder_Domain_Model_Group $group) {
		if ($group instanceof Tx_HelfenKannJeder_Domain_Model_Group
			&& $group->getOrganisation() instanceof Tx_HelfenKannJeder_Domain_Model_Organisation
			&& $this->accessControlService->isLoggedIn($group->getOrganisation()->getFeuser())) {

			// Calculate latitude and longitude
			if ($group->getAddress() != "") {
				$latlng = $this->googleMapsService->calculateLatitudeLongitude($group->getAddress());
				if (is_array($latlng) && count($latlng) == 2) {
					$group->setLatitude($latlng[0]);
					$group->setLongitude($latlng[1]);
				}
			}
			$this->groupRepository->update($group);
			$this->redirect('show', 'Organisation', NULL, array('organisation' => $group->getOrganisation()));
		} else {
			// wrong user or not logged in.
			$this->redirect('index', 'Organisation', NULL, array());
		}
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Group $group The group to delete
	 * @return void
	 */
	public function deleteAction(Tx_HelfenKannJeder_Domain_Model_Group $group) {
		if ($group instanceof Tx_HelfenKannJeder_Domain_Model_Group
			&& $group->getOrganisation() instanceof Tx_HelfenKannJeder_Domain_Model_Organisation
			&& $this->accessControlService->isLoggedIn($group->getOrganisation()->getFeuser())) {
			$organisation = $group->getOrganisation();
			$this->groupRepository->remove($group);
			$this->redirect('show', 'Organisation', NULL, array('organisation' => $organisation));
		} else {
			// wrong user or not logged in.
			$this->redirect('index', 'Organisation', NULL, array());
		}
	}
}
?>
