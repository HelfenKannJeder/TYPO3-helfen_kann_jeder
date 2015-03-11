<?php
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
	public function isValid(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation) {
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
