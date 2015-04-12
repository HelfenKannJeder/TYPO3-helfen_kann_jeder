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
 * Read and parse cookies.
 *
 * @author Valentin Zickner
 */
class CookieService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @param string $name Name of the cookie
	 */
	public function hasCookie($name) {
		return isset($_COOKIE[$name]);
	}

	/**
	 * @param string $name Name of the cookie
	 */
	public function getCookie($name) {
		return $_COOKIE[$name];
	}

	public function getPersonalCookie() {
		$persLat = 0.0;
		$persLng = 0.0;
		$age = 18;
		if ($this->hasCookie('hkj_info')) {
			$cookieInfo = explode('##1##', $this->getCookie('hkj_info'));
			if (count($cookieInfo) >= 5 && is_numeric($cookieInfo[0]) && is_numeric($cookieInfo[1])) {
				$persLat = (float)$cookieInfo[0];
				$persLng = (float)$cookieInfo[1];
			}
			if (count($cookieInfo) >= 5 && is_numeric($cookieInfo[4])) {
				$age = (int)$cookieInfo[4];
			}
		}

		return array($persLat, $persLng, $age);
	}
}
