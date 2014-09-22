<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Be\Link;

class PagePathViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper {
	/**
	 * Get the fullpath to a fe-page from backend. Used with the extension pagepath from Dimitry Dulepov
	 * @param integer $pageId
	 * @param array $parameters
	 * @return mixed
	 */
	public function render($pageId = NULL, $parameters = array()) {
		if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('pagepath', TRUE)) {
			require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('pagepath', 'class.tx_pagepath_api.php'));
			if (NULL === $pageId) {
				$pageId = $this->renderChildren();
			}
			return \tx_pagepath_api::getPagePath($pageId, $parameters);
		}
		return NULL;
	}
}
?>
