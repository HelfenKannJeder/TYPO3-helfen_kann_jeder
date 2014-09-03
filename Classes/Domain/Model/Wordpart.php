<?php
class Tx_HelfenKannJeder_Domain_Model_Wordpart
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Word
	 */
	protected $word;

	/**
	 * @var string
	 */
	protected $part;

	/**
	 * @var integer
	 */
	protected $position;

	/**
	 * @var integer
	 */
	protected $complete;

	public function __construct() {
	}

	public function getWord() {
		return $this->word;
	}

	public function setWord($word) {
		$this->word = $word;
	}

	public function getPart() {
		return $this->part;
	}

	public function setPart($part) {
		$this->part = $part;
	}

	public function getPosition() {
		return $this->position;
	}

	public function setPosition($position) {
		$this->position = $position;
	}

	public function getComplete() {
		return $this->complete;
	}

	public function setComplete($complete) {
		$this->complete = $complete;
	}
}
?>
