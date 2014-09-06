<?php
class Tx_HelfenKannJeder_Controller_GeneratorController
	extends Tx_HelfenKannJeder_Controller_AbstractSearchController {
	protected $organisationRepository;
	protected $matrixRepository;
	protected $groupRepository;
	protected $matrixFieldRepository;
	protected $activityRepository;
	protected $activityfieldRepository;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Repository_UserRepository
	 * @inject
	 */
	protected $userRepository;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository');
		$this->matrixRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_MatrixRepository');
		$this->groupRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupRepository');
		$this->matrixFieldRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_MatrixFieldRepository');

		$this->activityRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_ActivityRepository');
		$this->activityRepository->setDefaultOrderings(array('name'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));

		$this->activityfieldRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_ActivityFieldRepository');
		$this->activityfieldRepository->setDefaultOrderings(array('name'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));

		$this->userService = $this->objectManager->get('Tx_HelfenKannJeder_Service_UserService');
	}

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('activities', $this->activityRepository->findAll());
		$this->view->assign('activityfields', $this->activityfieldRepository->findAll());
	}

	/**
	 * @param array $activities
	 * @param integer $ind
	 * @param float $lat
	 * @param float $lng
	 * @param integer $age
	 * @param array $activityfields
	 * @param string $typeChange
	 * @param integer $newId
	 * @param string $newStatus
	 * @dontverifyrequesthash
	 * @return string
	 */
	public function ajaxorganisationAction($activities, $ind, $lat, $lng, $age, $activityfields=array(), $typeChange="", $newId=0, $newStatus="") {
		if ($age == 0) {
			$age = 18;
		}

		list($organisationsNear, $matrices) = $this->groupRepository->findOrganisationMatricesNearLatLng($lat, $lng, $age);
		$organisationsVoting = $this->matrixFieldRepository->findByMatrixFieldAndMatrix($activities, $activityfields, array_keys($organisationsNear), $matrices);

		$user = $this->userService->getBySessionId(session_id());

		if ($typeChange == "activity" || $typeChange == "activityfield") {
			if ($typeChange == "activity") {
				$userdo = new Tx_HelfenKannJeder_Domain_Model_UserdoActivity();
				$userdo->setActivity($newId);
			} else {
				$userdo = new Tx_HelfenKannJeder_Domain_Model_UserdoActivityfield();
				$userdo->setActivityfield($newId);
			}
			$userdo->setStatus($newStatus);
			$userdo->setUser($user);
			$user->addAction($userdo);
			$this->userRepository->update($user);
		}


		$organisations = $this->createOrganisationObjectsForTemplate($organisationsNear, $organisationsVoting, $lat, $lng);

		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		return json_encode(array(
			'status'  => "OK",
			'index' => $ind,
			'organisations' => $organisations,
		));
	}

	/**
	 * @param string $search
	 * @param integer $ident
	 * @dontverifyrequesthash
	 * @return string
	 */
	public function autocompleteAction($search, $ident) {
		$activities = $this->activityRepository->findByMatchingSearchParameter($search);

		$user = $this->userService->getBySessionId(session_id());

		$userdo = new Tx_HelfenKannJeder_Domain_Model_UserdoActivitysearch();
		$userdo->setInput($search);
		$userdo->setResult(count($activities));
		$userdo->setUser($user);
		$user->addAction($userdo);
		$this->userRepository->update($user);

		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

		$returnValue = json_encode(array(
			'status'  => "OK",
			'search' => $search,
			'activities' => $activities,
			'ident' => $ident
		));

		return $returnValue;
	}
}
?>