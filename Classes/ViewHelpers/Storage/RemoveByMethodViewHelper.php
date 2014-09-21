<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Storage;

class RemoveByMethodViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $method The method to prove
	 * @param mixed $method2 The method to prove
	 * @param mixed $value The result when it should be keept
	 * @return boolean contains or not
	 */
	public function render($storage, $method, $value, $method2=NULL) {
		if ($storage instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage || is_array($storage)) {
			$newStorage = array();
			foreach ($storage as $object) {
				$result1 = call_user_func(array(&$object, "get".ucfirst($method)));
				if (is_object($result1) && $method2 != null) {
					$result1 = call_user_func(array(&$result1, "get".ucfirst($method2)));
				}

				if ($result1 == $value) {
					$newStorage[] = $object;
				}
			}
			return $newStorage;
		} else {
			throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('RemoveByMethod viewhelpers can only be bound to properties of type ObjectStorage. Property "storage" is of type "' . (is_object($storage) ? get_class($storage) : gettype($storage)) . '".' , 1313581220);
		}
	}
}
?>
