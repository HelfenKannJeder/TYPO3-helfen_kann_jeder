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
class UserdoActivityfield extends Userdo {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Activityfield
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
