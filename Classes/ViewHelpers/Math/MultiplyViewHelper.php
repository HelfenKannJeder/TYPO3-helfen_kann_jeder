<?php
class Tx_HelfenKannJeder_ViewHelpers_Math_MultiplyViewHelper
	extends Tx_Fluid_ViewHelpers_BaseViewHelper {

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
