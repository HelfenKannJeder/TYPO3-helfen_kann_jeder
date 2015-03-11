<?php
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
