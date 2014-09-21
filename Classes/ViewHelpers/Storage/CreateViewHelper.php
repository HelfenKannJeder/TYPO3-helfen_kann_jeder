<?php
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
