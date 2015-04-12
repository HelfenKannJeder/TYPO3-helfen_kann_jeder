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

class DiffViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $object The object to search.
	 * @return boolean contains or not
	 */
	public function render($storage = NULL, $without = NULL) {
		if ($storage instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage
			&& $without instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
			return array_diff($storage->toArray(), $without->toArray());
		} else {
			throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Diff viewhelpers can only be bound to properties of type ObjectStorage. Property "storage" is of type "' . (is_object($storage) ? get_class($storage) : gettype($storage)) . '" and "without" is of type "' . (is_object($without) ? get_class($without) : gettype($without)) . '".' , 1313581220);
		}
	}
}
?>
