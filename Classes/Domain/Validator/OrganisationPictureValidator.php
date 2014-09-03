<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class validates for registration.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-31
 */
class Tx_HelfenKannJeder_Domain_Validator_OrganisationPictureValidator
	extends Tx_HelfenKannJeder_Domain_Validator_OrganisationAbstractValidator {
	protected $match;

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 */
	public function isValid($organisation) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft) {
			$returnValue = true;

			$pictures = explode(",", $organisation->getPictures());

			if (count($pictures) == 0 || trim($organisation->getPictures()) == "") {
/*				$this->addError('error_organisation_pictures_empty', 1328038440);
				$returnValue = false;*/
			} else {
				foreach ($pictures as $picture) {
					if (!file_exists($this->match.$picture)) {
						$this->addError('error_organisation_picture_not_found', 1328039058);
						$returnValue = false;
					} else if (($getImageSizeInfo = getimagesize($this->match.$picture)) === false) {
						$this->addError('error_organisation_picture_not_a_image', 1328039063);
						$returnValue = false;
					} else if ($getImageSizeInfo[0] < 600 || $getImageSizeInfo[1] < 600) {
						$this->addError('error_organisation_picture_to_small', 1328039067);
						$returnValue = false;
					}
				}
			}

			return $returnValue;
		}
		return false;
	}
}
?>
