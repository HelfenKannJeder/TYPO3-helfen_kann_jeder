<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an activity field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-12-02
 */
class Tx_HelfenKannJeder_Domain_Model_GroupTemplateCategory
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
	 * @var Tx_HelfenKannJeder_Domain_Model_OrganisationType
	 */
	protected $organisationtype;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_GroupTemplate>
	 */
	protected $groupTemplates;

	/**
	 * @var integer
	 */
	protected $sort;

	public function __construct() {
		$this->groupTemplates = new Tx_Extbase_Persistence_ObjectStorage();
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getOrganisationtype() {
		return $this->organisationtype;
	}

	public function setOrganisationtype($organisationtype) {
		$this->organisationtype = $organisationtype;
	}

	public function addGroupTemplates($groupTemplate) {
		$this->groupTemplates->attach($groupTemplate);
	}

	public function getGroupTemplates() {
		return $this->groupTemplates;
	}

	public function setSort($sort) {
		$this->sort = $sort;
	}

	public function getSort() {
		return $this->sort;
	}
}
?>
