<?php
namespace Querformatik\HelfenKannJeder\Service;

/**
 * Service to use features from the google maps api and other geocoding features.
 *
 * @author Valentin Zickner
 */
class GoogleMapsService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Log manager to log it when mail sending failed.
	 *
	 * @var TYPO3\CMS\Core\Log\LogManager
	 * @inject
	 */
	protected $logManager;

	/**
	 * Mail service
	 *
	 * @var \Tx_QuBase_Service_MailService
	 * @inject
	 */
	protected $mailService;

	/**
	 * Calculate the longitude and latitude to an address.
	 *
	 * @param A address in text format, for example: Gruenhutstr. 9, 76187 Karlsruhe
	 * @return array of informations about the address, possible there are more as
	 * one result.
	 */
	public function calculateCityAndDepartment($address) {
		$requestUrl = 'http://maps.googleapis.com/maps/api/geocode/xml?address=' . urlencode($address) . '&sensor=false&language=de';
		$xml = @simplexml_load_file($requestUrl);

		$addresses = array();
		if ($xml && $xml->status == 'OK') {
			foreach ($xml->children() as $address) {
				if ($address->getName() == 'result') {
					$addressParts = array();
					foreach ($address->children() as $component) {
						if ($component->getName() == 'address_component') {
							if (in_array($component->type, array('route', 'sublocality', 'locality', 'administrative_area_level_2',
								'administrative_area_level_3', 'administrative_area_level_1', 'country', 'postal_code'))) {
								$addressParts[(string)$component->type] = (string) $component->long_name;
								$addressParts[(string)$component->type . '_short'] = (string) $component->short_name;
							}
						}
						if ($component->getName() == 'geometry') {
							$addressParts['latitude'] = (double) $component->location->lat;
							$addressParts['longitude'] = (double) $component->location->lng;
						}
					}
					$addresses[] = $addressParts;
				}
			}
		} else {
			$logger = $this->logManager->getLogger(__CLASS__);
			$logger->error('Failed to connect to google maps', array($xml, $xml->status, $address));
			// TODO: Add a typoscript settings
			$this->mailService->send('valentin.zickner@helfenkannjeder.de', 'Failed to connect to google maps', $address);
		}
		return $addresses;
	}

	public function filterByDistance($organisations, $latitude, $longitude, $distance) {
		return array_filter($organisations, function ($organisation) use (&$latitude, &$longitude, &$distance) {
			return $this->approxDistance($organisation->getLatitude(), $organisation->getLongitude(), $latitude, $longitude) < $distance;
		});
	}

	public function sortByDistance($organisations, $latitude, $longitude) {
		usort($organisations, function ($first, $second) use (&$latitude, &$longitude) {
			return $this->approxDistance($first->getLatitude(), $first->getLongitude(), $latitude, $longitude) >
				$this->approxDistance($second->getLatitude(), $second->getLongitude(), $latitude, $longitude) ? 1 : -1;
		});
		return $organisations;
	}


	/**
	 * Calculate distance approximately between two coordinates.
	 *
	 * @param float p1lat Latitude from first coordinate
	 * @param float p1lng Longitude from first coordinate
	 * @param float p2lat Latitude from second coordinate
	 * @param float p2lng Longitude from second coordinate
	 * @return Distance between two points.
	 */
	public function approxDistance($p1lat, $p1lng, $p2lat, $p2lng) {
		// earth's mean radius in km
		$earthRadius = 6371;
		$dLat  = deg2rad($p2lat - $p1lat);
		$dLong = deg2rad($p2lng - $p1lng);

		$arc = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($p1lat)) * cos(deg2rad($p2lat)) * sin($dLong / 2) * sin($dLong / 2);
		$distance = $earthRadius * 2 * atan2(sqrt($arc), sqrt(1 - $arc));

		return round($distance, 3);
	}
}
