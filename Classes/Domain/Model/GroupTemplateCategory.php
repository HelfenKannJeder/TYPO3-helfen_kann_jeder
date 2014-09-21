<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an activity field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-12-02
 */
class GroupTemplateCategory extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType
	 */
	protected $organisationtype;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate>
	 */
	protected $groupTemplates;

	/**
	 * @var integer
	 */
	protected $sort;

	public function __construct() {
		$this->groupTemplates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
