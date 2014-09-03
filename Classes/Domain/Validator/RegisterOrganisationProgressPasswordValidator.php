<?php
class Tx_HelfenKannJeder_Domain_Validator_RegisterOrganisationProgressPasswordValidator
	extends Tx_Extbase_Validation_Validator_AbstractValidator {
	public function isValid($registerOrganisationProgress) {
		if (!$registerOrganisationProgress instanceof Tx_HelfenKannJeder_Domain_Model_RegisterOrganisationProgress) {
			$this->addError('The given Object is not a register organisation progress.', 1321617886);
			return FALSE;
		}

		if ($registerOrganisationProgress->getPassword() !== $registerOrganisationProgress->getPassword2()) {
			$this->addError('The passwords do not match.', 1321614404);
		}

		return TRUE;
	}
} 
?>
