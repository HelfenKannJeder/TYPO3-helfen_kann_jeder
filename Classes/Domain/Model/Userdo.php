<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents a user.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-08-19
 */
class Tx_HelfenKannJeder_Domain_Model_Userdo extends Tx_Extbase_DomainObject_AbstractValueObject {
	/**
	 * @var integer
	 */
	protected $timestamp;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_User
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
