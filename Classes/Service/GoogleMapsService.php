<?php
namespace Querformatik\HelfenKannJeder\Service;

class GoogleMapsService implements \TYPO3\CMS\Core\SingletonInterface {
	protected $googleServer = "";
	protected $googleApiKey = "";

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

	public function setGoogleServer($googleServer) {
		$this->googleServer = $googleServer;
	}

	public function getGoogleServer() {
		return $this->googleServer;
	}

	public function setGoogleApiKey($googleApiKey) {
		$this->googleApiKey = $googleApiKey;
	}

	public function getGoogleApiKey() {
		return $this->googleApiKey;
	}

	/**
	 * Calculate the longitude and latitude to an address.
	 *
	 * @param A address in text format, for example: Gruenhutstr. 9, 76187 Karlsruhe
	 * @return If the operation success and google found the address, the method will
	 *	return an array with two entries, first latitude, second is longitude. In all
	 *	other case it will return the status code as integer.
	 */
	// TODO redundant code
	public function calculateLatitudeLongitude($address) {
		$base_url = "http://" . $this->getGoogleServer() . "/maps/geo?output=xml"
			. "&key=" . $this->getGoogleApiKey();

		$request_url = $base_url . "&q=" . urlencode($address);
		$xml = @simplexml_load_file($request_url);

		if ($xml) {
			$status = $xml->Response->Status->code;
			if (strcmp($status, "200") == 0) {
				// Successful geocode
				$coordinates = $xml->Response->Placemark->Point->coordinates;
				$coordinatesSplit = explode(",", $coordinates);
				// Format: Longitude, Latitude, Altitude
				$lat = $coordinatesSplit[1];
				$lng = $coordinatesSplit[0];
                        
				return array($lat, $lng);
			}
		}

		$logger = $this->logManager->getLogger(__CLASS__);
		$logger->error("Failed to connect to google maps", array($xml, $status, $address));
		// TODO: Add a typoscript settings
		$this->mailService->send("valentin.zickner@helfenkannjeder.de", "Failed to connect to google maps", $address);

		return array();
	}

	// TODO redundant code
	public function calculateCityAndDepartment($address) {
		$request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($address)."&sensor=false&language=de";
		$xml = @simplexml_load_file($request_url);

		$addresses = array();
		if ($xml && $xml->status == "OK") {
			foreach ($xml->children() as $address) {
				if ($address->getName() == "result") {
					$addressParts = array();
					foreach ($address->children() as $component) {
						if ($component->getName() == "address_component") {
							if (in_array($component->type, array("route", "sublocality", "locality", "administrative_area_level_2", "administrative_area_level_3",
												"administrative_area_level_1", "country", "postal_code"))) {
								$addressParts[(string)$component->type] = $component->long_name;
								$addressParts[(string)$component->type."_short"] = $component->short_name;
							}
						}
						if ($component->getName() == "geometry") {
							$addressParts["latitude"] = $component->location->lat;
							$addressParts["longitude"] = $component->location->lng;
						}
					}
					$addresses[] = $addressParts;
				}
			}
		} else {
			$logger = $this->logManager->getLogger(__CLASS__);
			$logger->error("Failed to connect to google maps", array($xml, $xml->status, $address));
			// TODO: Add a typoscript settings
			$this->mailService->send("valentin.zickner@helfenkannjeder.de", "Failed to connect to google maps", $address);
		}
		return $addresses;
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
		$R = 6371; // earth's mean radius in km
		$dLat  = deg2rad($p2lat - $p1lat);
		$dLong = deg2rad($p2lng - $p1lng);

		$a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($p1lat)) * cos(deg2rad($p2lat)) * sin($dLong/2) * sin($dLong/2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$d = $R * $c;

		return round($d,3);
	}
}
?>
