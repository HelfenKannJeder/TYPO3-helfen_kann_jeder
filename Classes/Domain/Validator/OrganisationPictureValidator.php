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
