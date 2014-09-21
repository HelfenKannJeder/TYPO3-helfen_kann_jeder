<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Math;

class MultiplyViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param mixed $a First value.
	 * @param mixed $b Second value
	 * @param mixed $c Third value [default=1]
	 * @return boolean $a*$b*$c
	 */
	public function render($a = NULL, $b, $c=1) {
		if ($a === NULL) {
			$a = $this->renderChildren();
		}
		return $a*$b*$c;
	}
}
?>
