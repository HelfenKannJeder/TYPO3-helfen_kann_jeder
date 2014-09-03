<?php
class Tx_HelfenKannJeder_Service_UserService implements t3lib_Singleton {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Repository_UserRepository
	 * @inject
	 */
	protected $userRepository;

	public function getBySessionId($session) {
		$users = $this->userRepository->findBySession($session);
		if (count($users) == 0) {
			$user = new Tx_HelfenKannJeder_Domain_Model_User();
			$user->setSession($session);
			$ip = explode(".", $_SERVER["REMOTE_ADDR"]);
			$ip[2] = $ip[3] = 0;
			$user->setIp(implode(".",$ip));
			$user->setBrowser($_SERVER["HTTP_USER_AGENT"]);
			$this->userRepository->add($user);
		} else {
			$user = $users->getFirst();
		}
		$user->setLastactivity(time());
		return $user;
	}
}
?>
