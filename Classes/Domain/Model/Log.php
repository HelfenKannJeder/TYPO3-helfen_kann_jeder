<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an log entry.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-04-11
 */
class Tx_HelfenKannJeder_Domain_Model_Log
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 */
	protected $feuser;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_OrganisationDraft
	 */
	protected $organisation;

	public function __construct() {
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	public function getMessage() {
		return $this->message;
	}

	public function setFeuser($feuser) {
		$this->feuser = $feuser;
	}

	public function getFeuser() {
		return $this->feuser;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}
}
?>

