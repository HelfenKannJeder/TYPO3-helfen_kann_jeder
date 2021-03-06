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

class CreateViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param mixed $text Text to create storage from.
	 * @param mixed $seperator Seperator between entrys.
	 * @return boolean contains or not
	 */
	public function render($text = NULL, $seperator = ',') {
		if (empty($text)) {
			return array();
		} else if (is_string($text)) {
			return explode($seperator, $text);
		} else {
			throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Create viewhelpers can only be bound to properties of type String. Property "text" is of type "' . (is_object($text) ? get_class($text) : gettype($text)) . '" and "seperator" is of type "' . (is_object($seperator) ? get_class($seperator) : gettype($seperator)) . '".' , 1326639018);
		}
	}
}
?>
