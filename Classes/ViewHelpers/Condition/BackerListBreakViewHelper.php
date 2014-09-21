<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Condition;

class BackerListBreakViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

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
