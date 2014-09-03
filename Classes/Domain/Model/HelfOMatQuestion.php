<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an helf-o-mat catalog.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-06-15
 */
class Tx_HelfenKannJeder_Domain_Model_HelfOMatQuestion
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_HelfOMat
	 */
	protected $helfomat;

	/**
	 * @var string
	 */
	protected $question;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Activity>
	 */
	protected $positive;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Activity>
	 */
	protected $negative;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Activity>
	 */
	protected $positivenot;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Activity>
	 */
	protected $negativenot;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupPositive;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupNegative;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupPositivenot;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupNegativenot;

	/**
	 * @var integer
	 */
	protected $sort;

	public function __construct() {
		$this->positive = new Tx_Extbase_Persistence_ObjectStorage();
		$this->negative = new Tx_Extbase_Persistence_ObjectStorage();
		$this->positivenot = new Tx_Extbase_Persistence_ObjectStorage();
		$this->negativenot = new Tx_Extbase_Persistence_ObjectStorage();

		$this->groupPositive = new Tx_Extbase_Persistence_ObjectStorage();
		$this->groupNegative = new Tx_Extbase_Persistence_ObjectStorage();
		$this->groupPositivenot = new Tx_Extbase_Persistence_ObjectStorage();
		$this->groupNegativenot = new Tx_Extbase_Persistence_ObjectStorage();
	}

	public function setHelfomat($helfomat) {
		$this->helfomat = $helfomat;
	}

	public function getHelfomat() {
		return $this->helfomat;
	}

	public function setQuestion($question) {
		$this->question = $question;
	}

	public function getQuestion() {
		return $this->question;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setPositive($positive) {
		$this->positive = $positive;
	}

	public function getPositive() {
		return $this->positive;
	}

	public function addPositive($positive) {
		$this->positive->attach($positive);
	}

	public function removePositive($positive) {
		$this->positive->detach($positive);
	}

	public function setNegative($negative) {
		$this->negative = $negative;
	}

	public function getNegative() {
		return $this->negative;
	}

	public function addNegative($negative) {
		$this->negative->attach($negative);
	}

	public function removeNegative($negative) {
		$this->negative->detach($negative);
	}

	public function setPositivenot($positivenot) {
		$this->positivenot = $positivenot;
	}

	public function getPositivenot() {
		return $this->positivenot;
	}

	public function addPositivenot($positivenot) {
		$this->positivenot->attach($positivenot);
	}

	public function removePositivenot($positivenot) {
		$this->positivenot->detach($positivenot);
	}

	public function setNegativenot($negativenot) {
		$this->negativenot = $negativenot;
	}

	public function getNegativenot() {
		return $this->negativenot;
	}

	public function addNegativenot($negativenot) {
		$this->negativenot->attach($negativenot);
	}

	public function removeNegativenot($negativenot) {
		$this->negativenot->detach($negativenot);
	}

	public function setGroupPositive($groupPositive) {
		$this->groupPositive = $groupPositive;
	}

	public function getGroupPositive() {
		return $this->groupPositive;
	}

	public function addGroupPositive($groupPositive) {
		$this->groupPositive->attach($groupPositive);
	}

	public function removeGroupPositive($groupPositive) {
		$this->groupPositive->detach($groupPositive);
	}

	public function setGroupNegative($groupNegative) {
		$this->groupNegative = $groupNegative;
	}

	public function getGroupNegative() {
		return $this->groupNegative;
	}

	public function addGroupNegative($groupNegative) {
		$this->groupNegative->attach($groupNegative);
	}

	public function removeGroupNegative($groupNegative) {
		$this->groupNegative->detach($groupNegative);
	}

	public function setGroupPositivenot($groupPositivenot) {
		$this->groupPositivenot = $groupPositivenot;
	}

	public function getGroupPositivenot() {
		return $this->groupPositivenot;
	}

	public function addGroupPositivenot($groupPositivenot) {
		$this->groupPositivenot->attach($groupPositivenot);
	}

	public function removeGroupPositivenot($groupPositivenot) {
		$this->groupPositivenot->detach($groupPositivenot);
	}

	public function setGroupNegativenot($groupNegativenot) {
		$this->groupNegativenot = $groupNegativenot;
	}

	public function getGroupNegativenot() {
		return $this->groupNegativenot;
	}

	public function addGroupNegativenot($groupNegativenot) {
		$this->groupNegativenot->attach($groupNegativenot);
	}

	public function removeGroupNegativenot($groupNgativenot) {
		$this->groupNegativenot->detach($groupNegativenot);
	}

	public function getSort() {
		return $this->sort;
	}

	public function setSort($sort) {
		$this->sort = $sort;
	}
}
?>
