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
class OrganisationInformationValidator extends OrganisationAbstractValidator {

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 * 	$organisation
	 */
	public function isValid($organisation) {
		$returnValue = TRUE;
		// Prove name.
		$longestWordCount = $this->getLongestWordLength($organisation->getName());
		if ($organisation->getName() == '') {
			$this->addError('error_organisation_name_empty', 1332276437);
			$this->addInvalidField('organisation', $organisation->getUid(), 'name');
			$returnValue = FALSE;
		} elseif ($longestWordCount > self::LIMIT_LONGEST_WORD_LENGTH) {
			$this->addError('error_organisation_name_longest_word_to_long', 1332276951,
				array($longestWordCount, self::LIMIT_LONGEST_WORD_LENGTH));
			$this->addInvalidField('organisation', $organisation->getUid(), 'name');
			$returnValue = FALSE;
		}

		// Prove description.
		$longestWordCount = $this->getLongestWordLength($organisation->getDescription());
		if ($organisation->getDescription() == '') {
			$this->addError('error_organisation_description_empty', 1326743545);
			$this->addInvalidField('organisation', $organisation->getUid(), 'description');
			$returnValue = FALSE;
		} elseif ($longestWordCount > self::LIMIT_LONGEST_WORD_LENGTH) {
			$this->addError('error_organisation_description_longest_word_to_long', 1326797806,
				array($longestWordCount, self::LIMIT_LONGEST_WORD_LENGTH));
			$this->addInvalidField('organisation', $organisation->getUid(), 'description');
			$returnValue = FALSE;
		}

		// Prove website
		if ($organisation->getWebsite() != '') {
			if (!$this->isValidUrl($organisation->getWebsite())) {
				$this->addError('error_organisation_invalid_url', 1326797325);
				$this->addInvalidField('organisation', $organisation->getUid(), 'website');
				$returnValue = FALSE;
			}
		}

		if ($organisation->getLogo() == '') {
			$this->addError('error_organisation_no_logo', 1327073916);
			$this->addInvalidField('organisation', $organisation->getUid(), 'logo');
			$returnValue = FALSE;
		}

		return $returnValue;
	}
}
