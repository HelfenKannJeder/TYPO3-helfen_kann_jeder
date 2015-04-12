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
namespace Querformatik\HelfenKannJeder\ViewHelpers\Condition;

class BackerListBreakViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

	/**
	 * @param mixed $num The number to prove
	 * @return boolean Proves success or failed.
	 */
	public function render($num) {
		$index = $this->renderChildren();

		if (is_numeric($index)) {
			if (($index-3)%$num == 0) {
				return true;
			} else {
				return false;
			}
		}

	}
}
?>
