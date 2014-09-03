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
class Tx_HelfenKannJeder_Domain_Model_UserdoActivityfield extends Tx_HelfenKannJeder_Domain_Model_Userdo {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Activityfield
	 */
	protected $activityfield;

	/**
	 * @var integer
	 */
	protected $status;

	public function setActivityfield($activityfield) {
		$this->activityfield = $activityfield;
	}

	public function getActivityfield() {
		return $this->activityfield;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}
}
?>
