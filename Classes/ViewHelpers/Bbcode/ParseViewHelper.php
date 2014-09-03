<?php
class Tx_HelfenKannJeder_ViewHelpers_Bbcode_ParseViewHelper
	extends Tx_Fluid_ViewHelpers_BaseViewHelper {

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
