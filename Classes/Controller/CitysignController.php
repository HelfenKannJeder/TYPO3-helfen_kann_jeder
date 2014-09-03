<?php
// TODO: Class rewrite
class Tx_HelfenKannJeder_Controller_CitysignController
	extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_HelfenKannJeder_Service_UserService
	 * @inject
	 */
	protected $userRepository;

	public function indexAction() {
	}

	public function editAction() {
	}

	public function ajaxrememberaddressAction() {
		$arguments = $this->request->getArguments();

		$user = $this->userService->getBySessionId(session_id());

		$userdo = new Tx_HelfenKannJeder_Domain_Model_UserdoPersonaldata();
		$userdo->setAddress($arguments["address"]);
		$userdo->setStreet($arguments["street"]);
		$userdo->setCity($arguments["city"]);
		$userdo->setZipcode($arguments["zipcode"]);
		$userdo->setLongitude($arguments["longitude"]);
		$userdo->setLatitude($arguments["latitude"]);
		$userdo->setResponse($arguments["response"]);
		$userdo->setAge($arguments["age"]);
		$userdo->setUser($user);
		$user->addAction($userdo);
//		$stemmed = $this->stemmerService->stemList($arguments["search"]);

		return json_encode(array());
	}
}
?>
