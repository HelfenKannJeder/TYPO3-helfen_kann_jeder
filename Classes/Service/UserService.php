<?php
namespace Querformatik\HelfenKannJeder\Service;

class UserService implements \TYPO3\CMS\Core\SingletonInterface {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\UserRepository
	 * @inject
	 */
	protected $userRepository;

	public function getBySessionId($session) {
		$users = $this->userRepository->findBySession($session);
		if (count($users) == 0) {
			$user = new \Querformatik\HelfenKannJeder\Domain\Model\User();
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
