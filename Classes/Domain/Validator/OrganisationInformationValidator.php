<?php
namespace Querformatik\HelfenKannJeder\Domain\Validator;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class validates for registration.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-16
 */
class OrganisationInformationValidator extends OrganisationAbstractValidator {

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 */
	public function isValid(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation) {
		$returnValue = true;
		// Prove name.
		$longestWordCount = $this->getLongestWordLength($organisation->getName());
		if ($organisation->getName() == "") {
			$this->addError('error_organisation_name_empty', 1332276437);
			$this->addInvalidField('organisation', $organisation->getUid(), 'name');
			$returnValue = false;
		} else if ($longestWordCount > self::LIMIT_LONGEST_WORD_LENGTH) {
			$this->addError('error_organisation_name_longest_word_to_long', 1332276951, array($longestWordCount, self::LIMIT_LONGEST_WORD_LENGTH));
			$this->addInvalidField('organisation', $organisation->getUid(), 'name');
			$returnValue = false;
		}

		// Prove description.
		$longestWordCount = $this->getLongestWordLength($organisation->getDescription());
		if ($organisation->getDescription() == "") {
			$this->addError('error_organisation_description_empty', 1326743545);
			$this->addInvalidField('organisation', $organisation->getUid(), 'description');
			$returnValue = false;
		} else if ($longestWordCount > self::LIMIT_LONGEST_WORD_LENGTH) {
			$this->addError('error_organisation_description_longest_word_to_long', 1326797806, array($longestWordCount, self::LIMIT_LONGEST_WORD_LENGTH));
			$this->addInvalidField('organisation', $organisation->getUid(), 'description');
			$returnValue = false;
		}

		// Prove website
		if ($organisation->getWebsite() != "") {
			if (!$this->isValidUrl($organisation->getWebsite())) {
			//if (filter_var("http://".$organisation->getWebsite(), FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === false) {
				$this->addError('error_organisation_invalid_url', 1326797325);
				$this->addInvalidField('organisation', $organisation->getUid(), 'website');
				$returnValue = false;
			}
		} 

		if ($organisation->getLogo() == "") {
			$this->addError('error_organisation_no_logo', 1327073916);
			$this->addInvalidField('organisation', $organisation->getUid(), 'logo');
			$returnValue = false;
		}

		return $returnValue;
	}
}
?>
