<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen KAnn Jeder" Project
 *
 * @description: This class represents a matrix field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-05-13
 */
class MatrixField extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Matrix
	 */
	protected $matrix;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 *	The organisation of this layer.
	 */
	protected $organisation;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Activity
	 */
	protected $activity;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\ActivityField
	 */
	protected $activityfield;

	/**
	 * @var integer
	 * 	The grade of this connection.
	 */
	protected $grade;

	public function __construct($matrix, $organisation, $activity, $activityfield, $grade) {
		$this->setMatrix($matrix);
		$this->setOrganisation($organisation);
		$this->setActivity($activity);
		$this->setActivityfield($activityfield);
		$this->setGrade($grade);
	}

	public function setMatrix($matrix) {
		$this->matrix = $matrix;
	}

	public function getMatrix() {
		return $this->matrix;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setActivity($activity) {
		$this->activity = $activity;
	}

	public function getActivity() {
		return $this->activity;
	}

	public function setActivityfield($activityfield) {
		$this->activityfield = $activityfield;
	}

	public function getActivityfield() {
		return $this->activityfield;
	}

	public function setGrade($grade) {
		$this->grade = $grade;
	}

	public function getGrade() {
		return $this->grade;
	}
}
?>
