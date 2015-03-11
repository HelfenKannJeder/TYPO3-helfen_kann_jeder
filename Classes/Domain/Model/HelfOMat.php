<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an helf-o-mat catalog.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-06-15
 */
class HelfOMat extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\HelfOMatQuestion>
	 */
	protected $questions;

	/**
	 * @var integer
	 */
	protected $used;

	/**
	 * @var integer
	 */
	protected $method;

	/**
	 * Method for using matrix based searching.
	 * @var integer
	 */
	public static $METHOD_MATRIX = 0;

	/**
	 * Method for using group based searching.
	 * @var integer
	 */
	public static $METHOD_GROUP = 1;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->questions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * @return void
	 */
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

	public function setQuestions($questions) {
		$this->questions = $questions;
	}

	public function getQuestions() {
		return $this->questions;
	}

	public function addQuestion($question) {
		$this->questions->attach($question);
	}

	public function removeQuestion($question) {
		$this->questions->detach($question);
	}

	public function setUsed($used) {
		$this->used = $used;
	}

	public function getUsed() {
		return $this->used;
	}

	public function setMethod($method) {
		$this->method = $method;
	}

	public function getMethod() {
		return $this->method;
	}
}
