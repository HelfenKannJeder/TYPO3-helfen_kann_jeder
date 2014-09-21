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
class OrganisationAddressValidator extends OrganisationAbstractValidator {

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 */
	public function isValid(\Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation) {
		$returnValue = true;
		if ($organisation->getDefaultaddress() == 0) {
			$this->addError('error_organisation_address_no_default_address', 1326798986);
			$returnValue = false;
		} else {
			$addressValid = $this->isValidDefaultAddress($organisation->getDefaultaddress());
			$returnValue &= $addressValid;
			if (!$addressValid)
				$this->addInvalidField('address', $organisation->getDefaultaddress()->getUid(), '');
		}

		$addresses = $organisation->getAddresses();
		if (count($addresses) == 0) {
			$this->addError('error_organisation_address_no_addresses_found', 1326799174);
			$returnValue = false;
		} else {
			foreach ($addresses as $address) {
				$addressValid = $this->isValidAddress($address);
				$returnValue &= $addressValid;
				if (!$addressValid)
					$this->addInvalidField('address', $address->getUid(), '');
			}
		}

		return $returnValue;
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\AdressDraft $address
	 */
	public function isValidAddress(\Querformatik\HelfenKannJeder\Domain\Model\AdressDraft $address) {
		$returnValue = true;
		if ($address->getLatitude() == 0 || $address->getLongitude() == 0) {
			$this->addError('error_organisation_address_not_found', 1326799082, array($address->getStreet(), $address->getCity()));
			$returnValue = false;
		}

		if (!$this->isInRange($address->getAddressappendix(), 0, self::LIMIT_MAX_STRING_LENGTH)) {
			$this->addError('error_organisation_appendix_to_long', 1326819485, array($address->getStreet(), $address->getCity(), strlen($address->getAddressappendix()), self::LIMIT_MAX_STRING_LENGTH));
			$this->addInvalidField('address', $address->getUid(), 'addressappendix');
			$returnValue = false;
		}

		if (!$this->isInRange($address->getStreet(), 1, self::LIMIT_MAX_STRING_LENGTH)) {
			$this->addError('error_organisation_street_out_of_range', 1326819917, array($address->getCity()));
			$this->addInvalidField('address', $address->getUid(), 'street');
			$returnValue = false;
		}

		if (!$this->isInRange($address->getZipcode(), 5, 5)) {
			$this->addError('error_organisation_zipcode_out_of_range', 1326819953, array($address->getCity()));
			$this->addInvalidField('address', $address->getUid(), 'zipcode');
			$returnValue = false;
		}

		if (!$this->isInRange($address->getCity(), 1, self::LIMIT_MAX_STRING_LENGTH)) {
			$this->addError('error_organisation_city_out_of_range', 1326819991, array($address->getStreet()));
			$this->addInvalidField('address', $address->getUid(), 'city');
			$returnValue = false;
		}

		if ($address->getTelephone() != "" && !$this->isValidPhonenumber($address->getTelephone())) {
			$this->addError('error_organisation_not_valid_phonenumber', 1326818816, array($address->getStreet(), $address->getCity()));
			$this->addInvalidField('address', $address->getUid(), 'telephone');
			$returnValue = false;
		}


		if (abs($address->getZipcode()-$this->match) > 400) {
			$this->addError('error_organisation_not_in_range_of_main_address', 1328019174, array($address->getZipcode(), $this->match));
			$this->addInvalidField('address', $address->getUid(), 'zipcode');
			$returnValue = false;
		}

		return $returnValue;
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\AddressDraft $address
	 */
	public function isValidDefaultAddress(\Querformatik\HelfenKannJeder\Domain\Model\AddressDraft $address) {
		if ($address->getTelephone() == "") {
			$this->addError('error_organisation_not_valid_phonenumber', 1326818816, array($address->getStreet(), $address->getCity()));
			$this->addInvalidField('address', $address->getUid(), 'telephone');
			$returnValue = false;
		}
		return $returnValue;
	}
}
?>
