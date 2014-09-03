<?php
class Tx_HelfenKannJeder_ViewHelpers_Storage_DiffViewHelper
	extends Tx_Fluid_ViewHelpers_BaseViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $object The object to search.
	 * @return boolean contains or not
	 */
	public function render($storage = NULL, $without = NULL) {
		if ($storage instanceof Tx_Extbase_Persistence_ObjectStorage
			&& $without instanceof Tx_Extbase_Persistence_ObjectStorage) {
			return array_diff($storage->toArray(), $without->toArray());
		} else {
			throw new Tx_Fluid_Core_ViewHelper_Exception('Diff viewhelpers can only be bound to properties of type ObjectStorage. Property "storage" is of type "' . (is_object($storage) ? get_class($storage) : gettype($storage)) . '" and "without" is of type "' . (is_object($without) ? get_class($without) : gettype($without)) . '".' , 1313581220);
		}
	}
}
?>
