<?php
class Tx_HelfenKannJeder_ViewHelpers_Be_Link_PagePathViewHelper extends Tx_Fluid_ViewHelpers_Be_AbstractBackendViewHelper {
	/**
	 * Get the fullpath to a fe-page from backend. Used with the extension pagepath from Dimitry Dulepov
	 * @param integer $pageId
	 * @param array $parameters
	 * @return mixed
	 */
	public function render($pageId = NULL, $parameters = array()) {
		if (t3lib_extMgm::isLoaded('pagepath', TRUE)) {
			require_once(t3lib_extMgm::extPath('pagepath', 'class.tx_pagepath_api.php'));
			if (NULL === $pageId) {
				$pageId = $this->renderChildren();
			}
			return tx_pagepath_api::getPagePath($pageId, $parameters);
		}
		return NULL;
	}
}
?>
