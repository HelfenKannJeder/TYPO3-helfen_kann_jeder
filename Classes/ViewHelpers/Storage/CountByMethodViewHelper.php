<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Storage;

class CountByMethodViewHelper
	extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $method The method to request to the object.
	 * @param mixed $methodResult The result what the method should be.
	 * @param mixed $sum The items what should be.
	 * @return boolean contains or not
	 */
	public function render($storage, $method, $methodResult = NULL, $sum = NULL) {
		$sumItems = 0;
		if ($storage instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
			foreach ($storage as $item) {
				$result = call_user_func(array(&$item, $method));
				if ($result == $methodResult) $sumItems++;
			}
		}
		return $sumItems != $sum;
	}
}
?>
