<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Diff;

class TextViewHelper
	extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

	/**
	 * @var Querformatik\HelfenKannJeder\Service\HtmlDiffService
	 * @inject
	 */
	protected $diffService;

	/**
	 * @param string $old The old reference text
	 * @param string $new The new text
	 * @return boolean Proves success or failed.
	 */
	public function render($old, $new=null) {
		if ($new == null) {
			$new = $this->renderChildren();
		}

		return $this->diffService->diff($old, $new);
	}
}
?>
