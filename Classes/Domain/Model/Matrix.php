<?php
/**
 * "Helfen KAnn Jeder" Project
 *
 * @description: This class represents a matrix.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-05-13
 */
class Tx_HelfenKannJeder_Domain_Model_Matrix extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var string
	 * 	Name of the matrix
	 */
	protected $name = '';

	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 */
	protected $feuser;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Organisation
	 */
	protected $organisation;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_MatrixField>
	 * @cascade remove
	 */
	protected $matrixfields;

	public function __construct() {
		$this->matrixfields = new Tx_Extbase_Persistence_ObjectStorage();
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
			if ($field instanceof Tx_HelfenKannJeder_Domain_Model_MatrixField
				&& $field->getActivity()->getUid() == $activity
				&& $field->getActivityfield()->getUid() == $activityfield) {
				return $field;
			}
		}
		return null;
	}

	public function addMatrixfield($matrixfield) {
		$this->matrixfields->attach($matrixfield);
	}

	public function removeMatrixfield($matrixfield) {
		$storage = new Tx_Extbase_Persistence_ObjectStorage();
		$storage->attach($matrixfield);
		$this->matrixfields->removeAll($storage);
	}
}
?>
