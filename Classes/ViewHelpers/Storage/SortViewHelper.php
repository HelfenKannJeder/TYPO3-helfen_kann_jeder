<?php
/*
 * Copyright (C) 2015 Valentin Zickner <valentin.zickner@helfenkannjeder.de>
 *
 * This file is part of HelfenKannJeder.
 *
 * HelfenKannJeder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HelfenKannJeder is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HelfenKannJeder.  If not, see <http://www.gnu.org/licenses/>.
 */
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
