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
class Tx_HelfenKannJeder_Domain_Model_Group
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Organisation
	 */
	protected $organisation;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $workinghours;

	/**
	 * @var string
	 */
	protected $website;

	/**
	 * @var integer
	 */
	protected $minimumAge;

	/**
	 * @var integer
	 */
	protected $maximumAge;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Matrix
	 */
	protected $matrix;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_GroupTemplate
	 */
	protected $template;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Employee>
	 * @lazy
	 */
	protected $contactpersons;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_GroupDraft
	 * @lazy
	 */
	protected $reference;

	/**
	 * @var integer
	 */
	protected $sort;

	public function __construct() {
		$this->contactpersons = new Tx_Extbase_Persistence_ObjectStorage();
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

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setWorkinghours($workinghours) {
		$this->workinghours = $workinghours;
	}

	public function getWorkinghours() {
		return $this->workinghours;
	}

	public function setWebsite($website) {
		$this->website = $website;
	}

	public function getWebsite() {
		return $this->website;
	}

	public function setMinimumAge($minimumAge) {
		$this->minimumAge = $minimumAge;
	}

	public function getMinimumAge() {
		return $this->minimumAge;
	}

	public function setMaximumAge($maximumAge) {
		$this->maximumAge = $maximumAge;
	}

	public function getMaximumAge() {
		return $this->maximumAge;
	}

	public function setMatrix($matrix) {
		$this->matrix = $matrix;
	}

	public function getMatrix() {
		return $this->matrix;
	}

	public function getContactpersons() {
		return clone $this->contactpersons;
	}

	public function addContactperson($contactperson) {
		$this->contactpersons->attach($contactperson);
	}

	public function removeContactperson($contactperson) {
		$this->contactpersons->detach($contactperson);
	}

	public function removeAllContactpersons() {
		foreach ($this->contactpersons as $person) {
			$this->contactpersons->detach($person);
		}
	}

	public function setReference($reference) {
		$this->reference = $reference;
	}

	public function getReference() {
		return $this->reference;
	}

	public function setSort($sort) {
		$this->sort = $sort;
	}

	public function getSort() {
		return $this->sort;
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

	public function getTemplate() {
		return $this->template;
	}
}
?>
