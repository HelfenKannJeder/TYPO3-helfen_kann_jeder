<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

class Word extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $word;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Activity
	 */
	protected $activity;

	/**
	 * @var integer
	 */
	protected $percent;

	public function __construct() {
	}

	public function getWord() {
		return $this->word;
	}

	public function setWord($word) {
		$this->word = $word;
	}

	public function getActivity() {
		return $this->activity;
	}

	public function setActivity($activity) {
		$this->activity = $activity;
	}
}
?>
