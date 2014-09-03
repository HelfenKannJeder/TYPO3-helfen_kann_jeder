<?php
class Tx_HelfenKannJeder_ViewHelpers_Storage_AtViewHelper
	extends Tx_Fluid_ViewHelpers_IfViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $index The object to search.
	 * @param mixed $index2 The object to search.
	 * @param string $content Iteration variable.
	 * @return boolean contains or not
	 */
	public function render($storage, $index, $index2 = NULL, $content = NULL) {
		if ($index2 === NULL) {
			$value = isset($storage[$index])? $storage[$index] : 0;
		} else {
			$value = isset($storage[$index][$index2])? $storage[$index][$index2] : 0;
		}

		if ($content != NULL) {
			$this->templateVariableContainer->add($content, $value);
			$value = $this->renderChildren();
			$this->templateVariableContainer->remove($content);
		}
		return $value;
	}
}
?>
