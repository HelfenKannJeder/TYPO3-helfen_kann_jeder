<?php
namespace Querformatik\HelfenKannJeder\Controller;

// TODO: Class rewrite
class CitysignController
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\UserService
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

		$userdo = new \Querformatik\HelfenKannJeder\Domain\Model\UserdoPersonaldata();
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
