<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Storage;

class ContainsViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $object The object to search.
	 * @return boolean contains or not
	 */
	public function render($storage = NULL, $object = NULL) {
		return ($storage instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage && $storage->contains($object)) || (is_array($storage) && in_array($object, $storage));
	}
}
?>
