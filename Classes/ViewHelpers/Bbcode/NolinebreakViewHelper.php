<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Bbcode;

class NolinebreakViewHelper
	extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

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
