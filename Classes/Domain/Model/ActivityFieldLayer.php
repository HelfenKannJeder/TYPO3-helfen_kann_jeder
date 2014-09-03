<?php
/**
 * "Helfen KAnn Jeder" Project
 *
 * @description: This class represents an activity field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-03-19
 */
class Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_ActivityField
	 *	The activity field of this layer.
	 */
	protected $activityfield;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Organisation
	 *	The organisation of this layer.
	 */
	protected $organisation;

	/**
	 * @var integer
	 * 	The grade of this connection.
	 */
	protected $grade;

	public function __construct($activityfield, $organisation, $grade) {
		$this->setActivityfield($activityfield);
		$this->setOrganisation($organisation);
		$this->setGrade($grade);
	}

	public function setActivityfield($activityfield) {
		$this->activityfield = $activityfield;
	}

	public function getActivityfield() {
		return $this->activityfield;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setGrade($grade) {
		$this->grade = $grade;
	}

	public function getGrade() {
		return $this->grade;
	}
}
?>
