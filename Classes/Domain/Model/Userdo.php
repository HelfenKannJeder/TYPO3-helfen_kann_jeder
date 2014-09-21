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
class Userdo extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {
	/**
	 * @var integer
	 */
	protected $timestamp;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\User
	 */
	protected $user;

	public function __construct() {
		$this->setTimestamp(time());
	}

	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function getUser() {
		return $this->user;
	}
}
?>
