<?php
class Tx_HelfenKannJeder_ViewHelpers_Storage_ContainsViewHelper
	extends Tx_Fluid_ViewHelpers_IfViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $object The object to search.
	 * @return boolean contains or not
	 */
	public function render($storage = NULL, $object = NULL) {
		return ($storage instanceof Tx_Extbase_Persistence_ObjectStorage && $storage->contains($object)) || (is_array($storage) && in_array($object, $storage));
	}
}
?>
