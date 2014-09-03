<?php
class Tx_HelfenKannJeder_ViewHelpers_Diff_TextViewHelper
	extends Tx_Fluid_ViewHelpers_IfViewHelper {

	/**
	 * @param string $old The old reference text
	 * @param string $new The new text
	 * @return boolean Proves success or failed.
	 */
	public function render($old, $new=null) {
		if ($new == null) {
			$new = $this->renderChildren();
		}

		$diffService = t3lib_div::makeInstance('Tx_HelfenKannJeder_Service_HtmlDiffService');

		return $diffService->diff($old, $new);
/*
		// TODO implement php diff function!
		$oldArray = explode("\n", $old);
		$newArray = explode("\n", $new);
		$diff = new Text_Diff('auto', array($oldArray, $newArray));
		$renderer = new Text_Diff_Renderer_inline(
			array(
				'ins_prefix' => '<span class="diff_text_added">',
				'ins_suffix' => '</span>',
				'del_prefix' => '<span class="diff_text_removed">',
				'del_suffix' => '</span>',
			)
		);

		return $renderer->render($diff);*/
	}
}
?>
