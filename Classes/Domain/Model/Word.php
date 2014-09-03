<?php
class Tx_HelfenKannJeder_Domain_Model_Word
		extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var string
	 */
	protected $word;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_Wordpart>
	 */
//	protected $wordparts;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Activity
	 */
	protected $activity;

	/**
	 * @var integer
	 */
	protected $percent;

	public function __construct() {
//		$this->wordparts = new Tx_Extbase_Persistence_ObjectStorage();
	}

	public function getWord() {
		return $this->word;
	}

	public function setWord($word) {
		$this->word = $word;
	}
/*
	public function addWordpart($wordpart) {
		$this->wordparts->attach($wordpart);
	}

	public function getWordparts() {
		return $this->wordparts;
	}
*/
	public function getActivity() {
		return $this->activity;
	}

	public function setActivity($activity) {
		$this->activity = $activity;
	}
}
?>
