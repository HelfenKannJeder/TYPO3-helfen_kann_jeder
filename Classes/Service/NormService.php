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
namespace Querformatik\HelfenKannJeder\Service;

/**
 * The norm service is for normalization of published values.
 *
 * @author Valentin Zickner
 */
class NormService implements \TYPO3\CMS\Core\SingletonInterface {

	const PHONE_NUMBER_PREFIX_FILE = 'EXT:helfen_kann_jeder/Resources/Private/Static/PhoneNumberPrefix.txt';

	public function phoneNumber($telephone) {
		$absFileName = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName(self::PHONE_NUMBER_PREFIX_FILE);
		$phoneNumberPrefixes = file($absFileName, FILE_IGNORE_NEW_LINES);

		$telephone = preg_replace('/^0049/i', '0', $telephone);
		$telephone = preg_replace('/^\+49/i', '0', $telephone);
		$telephone = preg_replace('/^0\ /i', '0', $telephone);
		$telephone = preg_replace('/[^0-9\ ]/i', ' ', $telephone);
		$telephone = preg_replace('/[\ ]+/i', ' ', $telephone);

		if (strpos($telephone, ' ') != strrpos($telephone, ' ') || strpos($telephone, ' ') === FALSE) {
			$telephone = preg_replace('/[^0-9]/i', '', $telephone);
			$numberFound = FALSE;
			for ($i = 3; $i < 8 && !$numberFound; $i++) {
				if (in_array(substr($telephone, 0, $i), $phoneNumberPrefixes)) {
					$telephone = substr($telephone, 0, $i) . ' ' . substr($telephone, $i);
					$numberFound = TRUE;
				}
			}
			if (!$numberFound) {
				$telephone = substr($telephone, 0, 5) . ' ' . substr($telephone, 5);
			}
		}
		$telephone = trim($telephone);
		return $telephone;
	}

}
