<?php
namespace Querformatik\HelfenKannJeder\Domain\Validator;

class RegisterOrganisationProgressPasswordValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {
	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress registerOrganisationProgress 
	 */
	public function isValid(\Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress) {
		if ($registerOrganisationProgress->getPassword() !== $registerOrganisationProgress->getPassword2()) {
			$this->addError('The passwords do not match.', 1321614404);
		}

		return TRUE;
	}
} 
?>
