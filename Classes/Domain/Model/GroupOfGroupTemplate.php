<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

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
class GroupOfGroupTemplate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate>
	 * @lazy
	 */
	protected $groupTemplates;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->groupTemplates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
