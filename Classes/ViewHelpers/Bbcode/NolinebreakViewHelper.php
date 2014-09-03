<?php
class Tx_HelfenKannJeder_ViewHelpers_Bbcode_NolinebreakViewHelper
	extends Tx_Fluid_ViewHelpers_BaseViewHelper {

	/**
	 * @param mixed $text First value.
	 * @return text without bbcodes
	 */
	public function render($text = NULL) {
		if ($text === NULL) {
			$text = $this->renderChildren();
		}

		$text = str_replace("\n", " ", $text);
		$text = str_replace("\r", " ", $text);
		return $text;
	}
}
?>
