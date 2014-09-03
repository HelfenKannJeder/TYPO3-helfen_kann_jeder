<?php
class Tx_HelfenKannJeder_Domain_Validator_GroupValidator
	extends Tx_Extbase_Validation_Validator_AbstractValidator {
	public function isValid($group) {
		if (! $group instanceof Tx_HelfenKannJeder_Domain_Model_Group) {
			$this->addError('The given Object is not a group.', 1307884111);
			return FALSE;
		}
		if (strlen($group->getName()) < 3) {
			$this->addError('The name is to short.', 1307884413);
			return FALSE;
		}
		return TRUE;
	}
} 
?>
