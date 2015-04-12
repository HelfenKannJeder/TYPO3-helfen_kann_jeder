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
namespace Querformatik\HelfenKannJeder\View\Matrix;

class Column extends \TYPO3\CMS\Extbase\Mvc\View\AbstractView {
	public function render() {
		if (!isset($this->variables["width"])) $this->variables["width"] = 1;
		if (!isset($this->variables["height"])) $this->variables["height"] = 1;
		if (!isset($this->variables["font"])) $this->variables["font"] = "fileadmin/arial.ttf";
		if(isset($this->variables["activityfield"])) {
			$name = $this->variables["activityfield"]->getName();
		}

		$columImage = imagecreatetruecolor(20, 250);
		imagesavealpha($columImage, true);

		$trans_colour = imagecolorallocatealpha($columImage, 0, 0, 0, 127);
		imagefill($columImage, 0, 0, $trans_colour);
   
		$black = imagecolorallocate($columImage, 0, 0, 0);

		imagettftext($columImage, 10, 90, 17, 240, $black, $this->variables["font"], $name);  

		ob_start(); 
		imagepng($columImage);
		return ob_get_clean();
	}
}
?>
