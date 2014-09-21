<?php
namespace \Querformatik\HelfenKannJeder\ViewHelpers;

class IsValidViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {


	/**
	 * @param mixed $errors List of know errors.
	 * @param string $object Object name.
	 * @param integer $id ID of object.
	 * @param string $property Name of the property.
	 * @return boolean contains or not
	 */
	public function render($errors, $object, $id, $property) {
		$errorEntry = array($object, $id, $property);
		if (in_array($errorEntry, $errors)) {
			return "organisation_invalid_field";
		} else {
			return "";
		}
	}
}
?>
