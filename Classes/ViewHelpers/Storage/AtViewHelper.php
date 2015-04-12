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

class AtViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $index The object to search.
	 * @param mixed $index2 The object to search.
	 * @param string $content Iteration variable.
	 * @return boolean contains or not
	 */
	public function render($storage, $index, $index2 = NULL, $content = NULL) {
		if ($index2 === NULL) {
			$value = isset($storage[$index])? $storage[$index] : 0;
		} else {
			$value = isset($storage[$index][$index2])? $storage[$index][$index2] : 0;
		}

		if ($content != NULL) {
			$this->templateVariableContainer->add($content, $value);
			$value = $this->renderChildren();
			$this->templateVariableContainer->remove($content);
		}
		return $value;
	}
}
?>
