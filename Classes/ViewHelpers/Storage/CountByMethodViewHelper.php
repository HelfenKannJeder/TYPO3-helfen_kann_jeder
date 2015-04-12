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

class CountByMethodViewHelper
	extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $method The method to request to the object.
	 * @param mixed $methodResult The result what the method should be.
	 * @param mixed $sum The items what should be.
	 * @return boolean contains or not
	 */
	public function render($storage, $method, $methodResult = NULL, $sum = NULL) {
		$sumItems = 0;
		if ($storage instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
			foreach ($storage as $item) {
				$result = call_user_func(array(&$item, $method));
				if ($result == $methodResult) $sumItems++;
			}
		}
		return $sumItems != $sum;
	}
}
?>
