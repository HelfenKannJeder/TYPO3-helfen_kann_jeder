<?php
class Tx_HelfenKannJeder_ViewHelpers_Condition_BackerListBreakViewHelper
	extends Tx_Fluid_ViewHelpers_IfViewHelper {

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
