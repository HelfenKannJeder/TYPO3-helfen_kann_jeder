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
class UserdoActivity extends Userdo {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Activity
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
