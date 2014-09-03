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
class Tx_HelfenKannJeder_Domain_Validator_OrganisationEmployeeValidator
	extends Tx_HelfenKannJeder_Domain_Validator_OrganisationAbstractValidator {

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 */
	public function isValid($organisation) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft) {
			$returnValue = true;

			foreach ($organisation->getEmployees() as $employee) {
				$employeeValid = $this->isValidEmployee($employee);
				$returnValue &= $employeeValid;
				if (!$employeeValid)
					$this->addInvalidField('employee', $employee->getUid(), '');
			}

			return $returnValue;
		}
		return false;
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_EmployeeDraft $employee
	 */
	public function isValidEmployee($employee) {
		$returnValue = true;
		if ($employee instanceof Tx_HelfenKannJeder_Domain_Model_EmployeeDraft && !$employee->getIscontact()) {
			if (trim($employee->getPrename()) == "") {
				$this->addError('error_organisation_employee_person_missing_prename', 1327013197);
				$this->addInvalidField('employee', $employee->getUid(), 'prename');
				$returnValue = false;
			}

			if (trim($employee->getMotivation()) == "") {
				$this->addError('error_organisation_employee_person_missing_motivation', 1327013214, array($employee->getPrename()));
				$this->addInvalidField('employee', $employee->getUid(), 'motivation');
				$returnValue = false;
			}

			if ($employee->getTelephone() != "" && !$this->isValidPhonenumber($employee->getTelephone())) {
				$this->addError('error_organisation_employee_invalid_phone_number', 1327013132);
				$this->addInvalidField('employee', $employee->getUid(), 'telephone');
				$returnValue = false;
			}

			if ($employee->getMobilephone() != "" && !$this->isValidPhonenumber($employee->getMobilephone())) {
				$this->addError('error_organisation_employee_invalid_mobilephone_number', 1327013138);
				$this->addInvalidField('employee', $employee->getUid(), 'mobilephone');
				$returnValue = false;
			}
		}
		return $returnValue;
	}
}
?>
