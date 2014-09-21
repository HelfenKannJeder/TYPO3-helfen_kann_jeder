<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents a user.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-08-19
 */
class UserdoPersonaldata extends Userdo {
	/**
	 * @var string
	 */
	protected $address;

	/**
	 * @var string
	 */
	protected $street;

	/**
	 * @var string
	 */
	protected $city;

	/**
	 * @var string
	 */
	protected $zipcode;

	/**
	 * @var float
	 */
	protected $longitude;

	/**
	 * @var float
	 */
	protected $latitude;

	/**
	 * @var string
	 */
	protected $response;

	/**
	 * @var integer
	 */
	protected $age;

	public function setAddress($address) {
		$this->address = $address;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setStreet($street) {
		$this->street = $street;
	}

	public function getStreet() {
		return $this->street;
	}

	public function setCity($city) {
		$this->city = $city;
	}

	public function getCity() {
		return $this->city;
	}

	public function setZipcode($zipcode) {
		$this->zipcode = $zipcode;
	}

	public function getZipcode() {
		return $this->zipcode;
	}

	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	public function getLongitude() {
		return $this->longitude;
	}

	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	public function getLatitude() {
		return $this->latitude;
	}

	public function setResponse($response) {
		$this->response = $response;
	}

	public function getResponse() {
		return $this->response;
	}

	public function setAge($age) {
		$this->age = $age;
	}

	public function getAge() {
		return $this->age;
	}
}
?>
