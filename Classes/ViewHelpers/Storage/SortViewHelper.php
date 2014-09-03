<?php
class Tx_HelfenKannJeder_ViewHelpers_Storage_SortViewHelper
	extends Tx_Fluid_ViewHelpers_BaseViewHelper {
	protected $sortBy = "";
	protected $sortType = "";

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage $storage 
	 * @param string $property The property to sort by. 
	 * @param string $direction The direction to sort by (ASC or DESC).
	 * @return Tx_Extbase_Persistence_ObjectStorage The object sotrted.
	 */
	public function render($storage, $property, $direction = "ASC") {
		$direction = strtolower($direction);
		if ($storage instanceof Tx_Extbase_Persistence_ObjectStorage) {
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
