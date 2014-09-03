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
class Tx_HelfenKannJeder_Domain_Model_UserdoActivity extends Tx_HelfenKannJeder_Domain_Model_Userdo {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Activity
	 */
	protected $activity;

	/**
	 * @var integer
	 */
	protected $status;

	public function setActivity($activity) {
		$this->activity = $activity;
	}

	public function getActivity() {
		return $this->activity;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}
}
?>
