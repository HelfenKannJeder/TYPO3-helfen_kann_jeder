<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents a user.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-08-19
 */
class User extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $session;

	/**
	 * @var integer
	 */
	protected $lastactivity;

	/**
	 * @var string
	 */
	protected $ip;

	/**
	 * @var string
	 */
	protected $browser;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\Userdo>
	 * @lazy
	 */
	protected $actions;

	public function __construct() {
		$this->actions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	public function setSession($session) {
		$this->session = $session;
	}

	public function getSession() {
		return $this->session;
	}

	public function setLastactivity($lastactivity) {
		$this->lastactivity = $lastactivity;
	}

	public function getLastactivity() {
		return $this->lastactivity;
	}

	public function setIp($ip) {
		$this->ip = $ip;
	}

	public function getIp() {
		return $this->ip;
	}

	public function setBrowser($browser) {
		$this->browser = $browser;
	}

	public function getBrowser() {
		return $this->browser;
	}

	public function getActions() {
		return clone $this->actions;
	}

	public function addAction($action) {
		$this->actions->attach($action);
	}
}
?>
