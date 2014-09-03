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
class Tx_HelfenKannJeder_Domain_Model_Activity
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
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_ActivityField>
	 */
	protected $activityFields;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Word>
	 */
	protected $words;

	/**
	 * @var string
	 */
	protected $keywords;

	public function __construct($name) {
		$this->activityFields = new Tx_Extbase_Persistence_ObjectStorage();
		$this->words = new Tx_Extbase_Persistence_ObjectStorage();
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
