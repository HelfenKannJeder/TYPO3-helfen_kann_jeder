<?php
namespace Querformatik\HelfenKannJeder\Domain\Validator;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class validates for registration.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-31
 */
class OrganisationPictureValidator extends OrganisationAbstractValidator {
	protected $match;

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 * 	$organisation
	 */
	public function isValid($organisation) {
		$returnValue = TRUE;

		$pictures = explode(',', $organisation->getPictures());

		if (!(count($pictures) == 0 || trim($organisation->getPictures()) == '')) {
			foreach ($pictures as $picture) {
				if (!file_exists($this->match . $picture)) {
					$this->addError('error_organisation_picture_not_found', 1328039058);
					$returnValue = FALSE;
				} elseif (($getImageSizeInfo = getimagesize($this->match . $picture)) === FALSE) {
					$this->addError('error_organisation_picture_not_a_image', 1328039063);
					$returnValue = FALSE;
				} elseif ($getImageSizeInfo[0] < 600 || $getImageSizeInfo[1] < 600) {
					$this->addError('error_organisation_picture_to_small', 1328039067);
					$returnValue = FALSE;
				}
			}
		}

		return $returnValue;
	}
}
