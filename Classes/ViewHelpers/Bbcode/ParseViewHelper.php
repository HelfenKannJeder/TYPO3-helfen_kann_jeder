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
namespace Querformatik\HelfenKannJeder\ViewHelpers\Bbcode;

class ParseViewHelper
	extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param mixed $text First value.
	 * @return text without bbcodes
	 */
	public function render($text = NULL) {
		if ($text === NULL) {
			$text = $this->renderChildren();
		}

		$text = preg_replace("/\[b\](.*)\[\/b\]/Usi", "<strong>\\1</strong>", $text); 
		$text = preg_replace_callback("/\[list\](.*)\[\/list\]/Usi", array(&$this, "modifyListItems"), $text); 
		return $text;
	}

	private function modifyListItems($parse) {
		$text = $parse[1];
		$parts = explode("[*]",$text);

		$newText = "";
		foreach ($parts as $part) {
			$part = trim($part);
			if (!empty($part)) {
				$newText .= "<li>".$part."</li>";
			}
		}

		return "<ul>".$newText."</ul>";
	}
}
?>
