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
class Activity
		extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\ActivityField>
	 */
	protected $activityFields;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\Word>
	 */
	protected $words;

	/**
	 * @var string
	 */
	protected $keywords;

	public function __construct($name) {
		$this->activityFields = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->words = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->setName($name);
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

	public function addActivityField($activityField) {
		$this->activityFields->attach($activityField);
	}

	public function getActivityFields() {
		return $this->activityFields;
	}

	public function addWord($word) {
		$this->words->attach($word);
	}

	public function getWords() {
		return $this->words;
	}

	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	public function getKeywords() {
		return $this->keywords;
	}
}
?>
