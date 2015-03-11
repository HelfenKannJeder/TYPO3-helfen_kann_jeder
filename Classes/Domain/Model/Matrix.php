<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen KAnn Jeder" Project
 *
 * @description: This class represents a matrix.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-05-13
 */
class Matrix extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 * 	Name of the matrix
	 */
	protected $name = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $feuser;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 */
	protected $organisation;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\MatrixField>
	 * @cascade remove
	 */
	protected $matrixfields;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->matrixfields = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setFeuser($feuser) {
		$this->feuser = $feuser;
	}

	public function getFeuser() {
		return $this->feuser;
	}

	public function getMatrixfields() {
		return clone $this->matrixfields;
	}

	public function getMatrixfield($activityfield, $activity) {
		foreach ($this->matrixfields as $field) {
			if ($field instanceof MatrixField
				&& $field->getActivity()->getUid() == $activity
				&& $field->getActivityfield()->getUid() == $activityfield) {
				return $field;
			}
		}
		return NULL;
	}

	public function addMatrixfield($matrixfield) {
		$this->matrixfields->attach($matrixfield);
	}

	public function removeMatrixfield($matrixfield) {
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$storage->attach($matrixfield);
		$this->matrixfields->removeAll($storage);
	}
}
