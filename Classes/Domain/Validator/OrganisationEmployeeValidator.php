<?php
/*
 * Copyright (C) 2015 Valentin Zickner <valentin.zickner@helfenkannjeder.de>
 *
 * This file is part of HelfenKannJeder.
 *
 * HelfenKannJeder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HelfenKannJeder is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HelfenKannJeder.  If not, see <http://www.gnu.org/licenses/>.
 */
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
class OrganisationEmployeeValidator extends OrganisationAbstractValidator {

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 * 	$organisation
	 */
	public function isValid($organisation) {
		$returnValue = TRUE;

		foreach ($organisation->getEmployees() as $employee) {
			$employeeValid = $this->isValidEmployee($employee);
			$returnValue &= $employeeValid;
			if (!$employeeValid) {
				$this->addInvalidField('employee', $employee->getUid(), '');
			}
		}

		return $returnValue;
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft $employee
	 */
	public function isValidEmployee(\Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft $employee) {
		$returnValue = TRUE;
		if (!$employee->getIscontact()) {
			if (trim($employee->getPrename()) == '') {
				$this->addError('error_organisation_employee_person_missing_prename', 1327013197);
				$this->addInvalidField('employee', $employee->getUid(), 'prename');
				$returnValue = FALSE;
			}

			if (trim($employee->getMotivation()) == '') {
				$this->addError('error_organisation_employee_person_missing_motivation', 1327013214, array($employee->getPrename()));
				$this->addInvalidField('employee', $employee->getUid(), 'motivation');
				$returnValue = FALSE;
			}

			if ($employee->getTelephone() != '' && !$this->isValidPhonenumber($employee->getTelephone())) {
				$this->addError('error_organisation_employee_invalid_phone_number', 1327013132);
				$this->addInvalidField('employee', $employee->getUid(), 'telephone');
				$returnValue = FALSE;
			}

			if ($employee->getMobilephone() != '' && !$this->isValidPhonenumber($employee->getMobilephone())) {
				$this->addError('error_organisation_employee_invalid_mobilephone_number', 1327013138);
				$this->addInvalidField('employee', $employee->getUid(), 'mobilephone');
				$returnValue = FALSE;
			}
		}
		return $returnValue;
	}
}
