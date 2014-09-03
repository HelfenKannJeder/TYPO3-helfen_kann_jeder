<?php
/**
 * HelfenKannJeder Project
 *
 * @description: This class represents an group of group templates. This
 *   can be used by different organisations.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    HelfenKannJeder e.V.
 * @date: 2013-11-09
 */
class Tx_HelfenKannJeder_Domain_Model_GroupOfGroupTemplate
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_GroupTemplate>
	 * @lazy
	 */
	protected $groupTemplates;

	public function __construct() {
		$this->groupTemplates = new Tx_Extbase_Persistence_ObjectStorage();
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function addGroupTemplates($groupTemplate) {
		$this->groupTemplates->attach($groupTemplate);
	}

	public function getGroupTemplates() {
		return $this->groupTemplates;
	}
}
?>
