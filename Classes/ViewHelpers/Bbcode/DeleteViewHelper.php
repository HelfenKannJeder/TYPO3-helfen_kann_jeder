<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Bbcode;

class DeleteViewHelper
	extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param mixed $text First value.
	 * @return text without bbcodes
	 */
	public function render($text = NULL) {
		if ($text === NULL) {
			$text = $this->renderChildren();
		}

		$text = preg_replace("/\[b\](.*)\[\/b\]/Usi", "\\1", $text); 
		$text = preg_replace_callback("/\[list\](.*)\[\/list\]/Usi", array(&$this, "removeListItems"), $text); 
		return $text;
	}

	private function removeListItems($parse) {
		$text = $parse[1];
		$text = str_replace("[*]", "", $text);
		return $text;
	}
}
?>
