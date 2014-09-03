<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class validates for registration.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-16
 */
class Tx_HelfenKannJeder_Domain_Validator_OrganisationContactpersonValidator
	extends Tx_HelfenKannJeder_Domain_Validator_OrganisationAbstractValidator {

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 */
	public function isValid($organisation) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft) {
			$returnValue = true;

			if (count($organisation->getContactpersons()) == 0) {
				$this->addError('error_organisation_no_contact_persons', 1326752230);
				$returnValue = false;
			} else {
				foreach ($organisation->getContactpersons() as $employee) {
					$contactValid = $this->isValidContactPerson($employee);
					$returnValue &= $contactValid;
					if (!$contactValid)
						$this->addInvalidField('employee', $employee->getUid(), '');
				}
			}

			foreach ($organisation->getEmployees() as $employee) {
				if ($employee->getIscontact() == 2) { // Contact person of a group
					$contactValid = $this->isValidContactPerson($employee);
					$returnValue &= $contactValid;
					if (!$contactValid)
						$this->addInvalidField('employee', $employee->getUid(), '');
				}
			}

			return $returnValue;
		}
		return false;
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_EmployeeDraft $employee
	 */
	public function isValidContactPerson($employee) {
		$returnValue = true;
		if ($employee instanceof Tx_HelfenKannJeder_Domain_Model_EmployeeDraft) {
			if (trim($employee->getSurname()) == "") {
				$this->addError('error_organisation_contact_person_missing_surname', 1327011153);
				$this->addInvalidField('employee', $employee->getUid(), 'surname');
				$returnValue = false;
			}

			if (trim($employee->getPrename()) == "") {
				$this->addError('error_organisation_contact_person_missing_prename', 1327011195);
				$this->addInvalidField('employee', $employee->getUid(), 'prename');
				$returnValue = false;
			}

			if (trim($employee->getMail()) == "" && trim($employee->getTelephone()) == "" && trim($employee->getMobilephone()) == "") {
				$this->addError('error_organisation_contact_person_missing_contact_possibility', 1327011315, array($employee->getPrename(),$employee->getSurname()));
				$this->addInvalidField('employee', $employee->getUid(), 'mail');
				$this->addInvalidField('employee', $employee->getUid(), 'telephone');
				$this->addInvalidField('employee', $employee->getUid(), 'mobilephone');
				$returnValue = false;
			}

			if ($employee->getMail() != "" && !$this->isValidMail($employee->getMail())) {
				$this->addError('error_organisation_contact_person_invalid_mail', 1330301612, array($employee->getPrename(),$employee->getSurname()));
				$this->addInvalidField('employee', $employee->getUid(), 'mail');
				$returnValue = false;
			}

			if ($employee->getTelephone() != "" && !$this->isValidPhonenumber($employee->getTelephone())) {
				$this->addError('error_organisation_contact_person_invalid_phone_number', 1327011824, array($employee->getPrename(),$employee->getSurname()));
				$this->addInvalidField('employee', $employee->getUid(), 'telephone');
				$returnValue = false;
			}

			if ($employee->getMobilephone() != "" && !$this->isValidPhonenumber($employee->getMobilephone())) {
				$this->addError('error_organisation_contact_person_invalid_mobilephone_number', 1327011933, array($employee->getPrename(),$employee->getSurname()));
				$this->addInvalidField('employee', $employee->getUid(), 'mobilephone');
				$returnValue = false;
			}
		}
		return $returnValue;
	}
}
?>
