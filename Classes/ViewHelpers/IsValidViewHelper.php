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
namespace Querformatik\HelfenKannJeder\ViewHelpers;

class IsValidViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {


	/**
	 * @param mixed $errors List of know errors.
	 * @param string $object Object name.
	 * @param integer $id ID of object.
	 * @param string $property Name of the property.
	 * @return boolean contains or not
	 */
	public function render($errors, $object, $id, $property) {
		$errorEntry = array($object, $id, $property);
		if (in_array($errorEntry, $errors)) {
			return "organisation_invalid_field";
		} else {
			return "";
		}
	}
}
?>
