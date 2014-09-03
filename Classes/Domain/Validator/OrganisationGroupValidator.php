<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class validates for registration.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-19
 */
class Tx_HelfenKannJeder_Domain_Validator_OrganisationGroupValidator
	extends Tx_HelfenKannJeder_Domain_Validator_OrganisationAbstractValidator {

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 */
	public function isValid($organisation) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft) {
			$returnValue = true;

			if ($organisation->getGroups()->count() == 0) {
				$this->addError('error_organisation_no_groups', 1327013762);
				$returnValue = false;
			} else {
				foreach ($organisation->getGroups() as $group) {
					$groupValid = $this->isValidGroup($group);
					$returnValue &= $groupValid;
					if (!$groupValid)
						$this->addInvalidField('group', $group->getUid(), '');
				}
			}

			return $returnValue;
		}
		return false;
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_GroupDraft $group
	 */
	public function isValidGroup($group) {
		$returnValue = true;
		if ($group instanceof Tx_HelfenKannJeder_Domain_Model_GroupDraft) {
			if (trim($group->getDescription()) == "") {
				$this->addError('error_organisation_group_missing_description', 1327013891, array($group->getName()));
				$this->addInvalidField('group', $group->getUid(), 'description');
				$returnValue = false;
			}

			if (trim($group->getMinimumAge()) == "") {
				$this->addError('error_organisation_group_missing_minimum_age', 1327013995, array($group->getName()));
				$this->addInvalidField('group', $group->getUid(), 'minimum_age');
				$returnValue = false;
			}
			else if (!is_numeric($group->getMinimumAge())) {
				$this->addError('error_organisation_group_minimum_age_not_a_number', 1327014100, array($group->getName()));
				$this->addInvalidField('group', $group->getUid(), 'minimum_age');
				$returnValue = false;
			}
			else if ($group->getMinimumAge() < 3 || $group->getMinimumAge() > 100) {
				$this->addError('error_organisation_group_minimum_age_out_of_range', 1327014281, array($group->getName(), 3, 100));
				$this->addInvalidField('group', $group->getUid(), 'minimum_age');
				$returnValue = false;
			}

			if (trim($group->getMaximumAge()) == "") {
				$this->addError('error_organisation_group_missing_maximum_age', 1327014022, array($group->getName()));
				$this->addInvalidField('group', $group->getUid(), 'maximum_age');
				$returnValue = false;
			}
			else if (!is_numeric($group->getMaximumAge())) {
				$this->addError('error_organisation_group_maximum_age_not_a_number', 1327014141, array($group->getName()));
				$this->addInvalidField('group', $group->getUid(), 'maximum_age');
				$returnValue = false;
			}
			else if ($group->getMaximumAge() < 3 || $group->getMaximumAge() > 100) {
				$this->addError('error_organisation_group_maximum_age_out_of_range', 1327014326, array($group->getName(), 3, 100));
				$this->addInvalidField('group', $group->getUid(), 'maximum_age');
				$returnValue = false;
			}

			if (is_numeric($group->getMinimumAge()) && is_numeric($group->getMaximumAge())
				&& $group->getMinimumAge() > $group->getMaximumAge()) {
				$this->addError('error_organisation_group_minimum_age_greater_than_maximum_age', 1327014403, array($group->getName(), $group->getMinimumAge(), $group->getMaximumAge()));
				$this->addInvalidField('group', $group->getUid(), 'minimum_age');
				$this->addInvalidField('group', $group->getUid(), 'maximum_age');
				$returnValue = false;
			}

			if ($group->getWebsite() != "" && !$this->isValidUrl($group->getWebsite())) {
				$this->addError('error_organisation_group_invalid_website', 1327017058, array($group->getName()));
				$this->addInvalidField('group', $group->getUid(), 'website');
				$returnValue = false;
			}

		}
		return $returnValue;
	}
}
?>
