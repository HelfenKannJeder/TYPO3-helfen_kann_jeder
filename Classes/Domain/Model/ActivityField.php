<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an activity field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-03-19
 */
class ActivityField extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\ActivityFieldLayer>
	 */
	protected $activityFieldLayers;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\Activity>
	 */
	protected $activities;

	public function __construct() {
		$this->activityFieldLayers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->activities = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
