<?php
namespace Querformatik\HelfenKannJeder\Domain\Validator;

/**
 * Password validator
 *
 * @author Valentin Zickner
 */
class RegisterOrganisationProgressPasswordValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress
	 * 	$registerProgress 
	 */
	public function isValid(\Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerProgress) {
		if ($registerProgress->getPassword() !== $registerProgress->getPassword2()) {
			$this->addError('The passwords do not match.', 1321614404);
		}

		return TRUE;
	}

}
