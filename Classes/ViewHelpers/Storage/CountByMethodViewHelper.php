<?php
class Tx_HelfenKannJeder_ViewHelpers_Storage_CountByMethodViewHelper
	extends Tx_Fluid_ViewHelpers_IfViewHelper {

	/**
	 * @param mixed $storage The object to search in.
	 * @param mixed $method The method to request to the object.
	 * @param mixed $methodResult The result what the method should be.
	 * @param mixed $sum The items what should be.
	 * @return boolean contains or not
	 */
	public function render($storage, $method, $methodResult = NULL, $sum = NULL) {
		$sumItems = 0;
		if ($storage instanceof Tx_Extbase_Persistence_ObjectStorage) {
			foreach ($storage as $item) {
				$result = call_user_func(array(&$item, $method));
				if ($result == $methodResult) $sumItems++;
			}
		}
		return $sumItems != $sum;
//		return ($storage instanceof Tx_Extbase_Persistence_ObjectStorage && $storage->contains($object)) || (is_array($storage) && in_array($object, $storage));
	}
}
?>
