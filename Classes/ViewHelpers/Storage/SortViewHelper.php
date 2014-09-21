<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Storage;

class SortViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {
	protected $sortBy = "";
	protected $sortType = "";

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $storage 
	 * @param string $property The property to sort by. 
	 * @param string $direction The direction to sort by (ASC or DESC).
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage The object sotrted.
	 */
	public function render($storage, $property, $direction = "ASC") {
		$direction = strtolower($direction);
		if ($storage instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
			$storage = $storage->toArray();
			$this->sortBy = "get".ucfirst($property);
			$this->sortType = $direction;
			usort($storage, array(&$this, "sortByProperty"));
		}
		return $storage;
	}

	protected function sortByProperty($a, $b) {
		if (method_exists($a, $this->sortBy) && method_exists($b, $this->sortBy)) {
			$valueA = call_user_func(array($a, $this->sortBy));
			$valueB = call_user_func(array($b, $this->sortBy));

			return ($sortType == "asc") ? ($valueA < $valueB) : ($valueA >= $valueB);
		} else {
			return 0;
		}
	}
}
?>
