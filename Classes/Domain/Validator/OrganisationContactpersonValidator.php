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
class OrganisationContactpersonValidator extends OrganisationAbstractValidator {

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 * 	$organisation
	 */
	public function isValid($organisation) {
		$returnValue = TRUE;

		if (count($organisation->getContactpersons()) == 0) {
			$this->addError('error_organisation_no_contact_persons', 1326752230);
			$returnValue = FALSE;
		} else {
			foreach ($organisation->getContactpersons() as $employee) {
				$contactValid = $this->isValidContactPerson($employee);
				$returnValue &= $contactValid;
				if (!$contactValid) {
					$this->addInvalidField('employee', $employee->getUid(), '');
				}
			}
		}

		foreach ($organisation->getEmployees() as $employee) {
			if ($employee->getIscontact() == 2) {
				// Contact person of a group
				$contactValid = $this->isValidContactPerson($employee);
				$returnValue &= $contactValid;
				if (!$contactValid) {
					$this->addInvalidField('employee', $employee->getUid(), '');
				}
			}
		}

		return $returnValue;
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft $employee
	 */
	public function isValidContactPerson(\Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft $employee) {
		$returnValue = TRUE;
		if (trim($employee->getSurname()) == '') {
			$this->addError('error_organisation_contact_person_missing_surname', 1327011153);
			$this->addInvalidField('employee', $employee->getUid(), 'surname');
			$returnValue = FALSE;
		}

		if (trim($employee->getPrename()) == '') {
			$this->addError('error_organisation_contact_person_missing_prename', 1327011195);
			$this->addInvalidField('employee', $employee->getUid(), 'prename');
			$returnValue = FALSE;
		}

		if (trim($employee->getMail()) == '' && trim($employee->getTelephone()) == '' && trim($employee->getMobilephone()) == '') {
			$this->addError('error_organisation_contact_person_missing_contact_possibility', 1327011315,
				array($employee->getPrename(), $employee->getSurname()));
			$this->addInvalidField('employee', $employee->getUid(), 'mail');
			$this->addInvalidField('employee', $employee->getUid(), 'telephone');
			$this->addInvalidField('employee', $employee->getUid(), 'mobilephone');
			$returnValue = FALSE;
		}

		if ($employee->getMail() != '' && !$this->isValidMail($employee->getMail())) {
			$this->addError('error_organisation_contact_person_invalid_mail', 1330301612,
				array($employee->getPrename(), $employee->getSurname()));
			$this->addInvalidField('employee', $employee->getUid(), 'mail');
			$returnValue = FALSE;
		}

		if ($employee->getTelephone() != '' && !$this->isValidPhonenumber($employee->getTelephone())) {
			$this->addError('error_organisation_contact_person_invalid_phone_number', 1327011824,
				array($employee->getPrename(), $employee->getSurname()));
			$this->addInvalidField('employee', $employee->getUid(), 'telephone');
			$returnValue = FALSE;
		}

		if ($employee->getMobilephone() != '' && !$this->isValidPhonenumber($employee->getMobilephone())) {
			$this->addError('error_organisation_contact_person_invalid_mobilephone_number', 1327011933,
				array($employee->getPrename(), $employee->getSurname()));
			$this->addInvalidField('employee', $employee->getUid(), 'mobilephone');
			$returnValue = FALSE;
		}
		return $returnValue;
	}
}
