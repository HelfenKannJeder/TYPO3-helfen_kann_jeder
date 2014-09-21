<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Storage;

class DiffViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $object The object to search.
	 * @return boolean contains or not
	 */
	public function render($storage = NULL, $without = NULL) {
		if ($storage instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage
			&& $without instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
			return array_diff($storage->toArray(), $without->toArray());
		} else {
			throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Diff viewhelpers can only be bound to properties of type ObjectStorage. Property "storage" is of type "' . (is_object($storage) ? get_class($storage) : gettype($storage)) . '" and "without" is of type "' . (is_object($without) ? get_class($without) : gettype($without)) . '".' , 1313581220);
		}
	}
}
?>
