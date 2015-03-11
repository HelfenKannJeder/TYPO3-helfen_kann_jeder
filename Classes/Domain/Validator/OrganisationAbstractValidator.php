<?php
namespace Querformatik\HelfenKannJeder\Domain\Validator;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class validates for registration.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-17
 */
abstract class OrganisationAbstractValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {
	const LIMIT_LONGEST_WORD_LENGTH = 50;
	const LIMIT_MAX_STRING_LENGTH = 50;

	protected $match;
	protected $invalidFields = array();

	/**
	 * @return void
	 */
	protected function addInvalidField($objectType, $fieldId, $fieldName) {
		$this->invalidFields[] = array($objectType, $fieldId, $fieldName);
	}

	public function getInvalidFields() {
		return $this->invalidFields;
	}

	protected function isValidMail($mail) {
		return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/si', $mail);
	}

	protected function isValidUrl($url) {
		return preg_match('/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i', $url);
	}

	protected function isValidPhonenumber($number) {
		return preg_match('/^([0-9]{3,6}\ [0-9\ ]{2})/i', $number);
	}

	protected function isInRange($string, $min, $max) {
		return strlen($string) <= $min || strlen($string) > $max;
	}

	protected function getLongestWordLength($string) {
		$parts = explode( ' ', $string );
		array_multisort(
			array_map( 'strlen', $parts ),
			SORT_DESC,
			SORT_NUMERIC,
			$parts
		);
		$longest = reset( $parts );
		return strlen($longest);
	}

	protected function addError($message, $code, $values = NULL) {
		if ($values == NULL) {
			$values = array();
		}
		$newMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($message, 'HelfenKannJeder', $values);
		if (empty($newMessage)) {
			$newMessage = $message . ' (' . $code . ')';
		}
		parent::addError($newMessage, $code);
	}

	public function setMatch($match) {
		$this->match = $match;
	}
}
