<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an activity field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-03-19
 */
class Tx_HelfenKannJeder_Domain_Model_ActivityField
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer>
	 */
	protected $activityFieldLayers;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Activity>
	 */
	protected $activities;

	public function __construct() {
		$this->activityFieldLayers = new Tx_Extbase_Persistence_ObjectStorage();
		$this->activities = new Tx_Extbase_Persistence_ObjectStorage();
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function addActivityFieldLayer($activityFieldLayer) {
		$this->activityFieldLayers->attach($activityFieldLayer);
	}

	public function getActivityFieldLayers() {
		return $this->activityFieldLayers;
	}

	public function addActivity($activity) {
		$this->activities->attach($activity);
	}

	public function getActivities() {
		return $this->activities;
	}
}
?>
