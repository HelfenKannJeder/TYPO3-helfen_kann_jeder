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
 * @date: 2012-01-19
 */
class OrganisationWorkinghourValidator extends OrganisationAbstractValidator {

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 * 	$organisation
	 */
	public function isValid($organisation) {
		$returnValue = TRUE;

		if (count($organisation->getWorkinghours()) == 0) {
			$this->addError('error_organisation_no_workinghours', 1327018602);
			$returnValue = FALSE;
		} else {
			foreach ($organisation->getWorkinghours() as $workinghour) {
				$workinghourValid = $this->isValidWorkinghour($workinghour);
				$returnValue &= $workinghourValid;
				if (!$workinghourValid) {
					$this->addInvalidField('workinghour', $workinghour->getUid(), '');
				}
			}
		}

		return $returnValue;
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\WorkinghourDraft
	 * 	$workinghour
	 */
	public function isValidWorkinghour(\Querformatik\HelfenKannJeder\Domain\Model\WorkinghourDraft $workinghour) {
		$returnValue = TRUE;
		if ($workinghour->getDay() == 0) {
			$this->addError('error_organisation_workinghours_no_day_given', 1327018741);
			$this->addInvalidField('workinghour', $workinghour->getUid(), 'day');
			$returnValue = FALSE;
		}

		if ($workinghour->getStarttimehour() == 0 && $workinghour->getStarttimeminute() == 0
			&& $workinghour->getStoptimehour() == 0 && $workinghour->getStoptimeminute() == 0) {
			$this->addError('error_organisation_workinghours_not_all_time_values_should_be_null', 1327018854);
			$this->addInvalidField('workinghour', $workinghour->getUid(), 'time');
			$returnValue = FALSE;
		}

		if (!($workinghour->getStarttimehour() < $workinghour->getStoptimehour() ||
			($workinghour->getStarttimehour() == $workinghour->getStoptimehour() &&
				$workinghour->getStarttimeminute() < $workinghour->getStoptimeminute()))) {
				$this->addError('error_organisation_not_valid_time_period', 1327019035,
					array($workinghour->getStarttimehour(), $workinghour->getStarttimeminute(), $workinghour->getStoptimehour(),
						$workinghour->getStoptimeminute()));
			$this->addInvalidField('workinghour', $workinghour->getUid(), 'time');
			$returnValue = FALSE;
		}
		return $returnValue;
	}
}
