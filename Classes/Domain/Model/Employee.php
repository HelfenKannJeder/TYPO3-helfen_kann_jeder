<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen KAnn Jeder" Project
 *
 * @description: This class represents an employee.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-03-19
 */
class Employee extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 */
	protected $organisation; 

	/**
	 * @var string
	 * 	The main picture displayed at the overview.
	 */
	protected $pictures = '';

	/**
	 * @var string
	 */
	protected $rank = '';

	/**
	 * @var string
	 */
	protected $headline = '';

	/**
	 * @var string
	 */
	protected $motivation = '';

	/**
	 * @var string
	 */
	protected $surname = '';

	/**
	 * @var string
	 */
	protected $prename = '';

	/**
	 * @var integer
	 */
	protected $birthday = '';

	/**
	 * @var string
	 */
	protected $mail = '';

	/**
	 * @var string
	 */
	protected $street = '';

	/**
	 * @var string
	 */
	protected $city = '';

	/**
	 * @var string
	 */
	protected $telephone = '';

	/**
	 * @var string
	 */
	protected $mobilephone = '';

	/**
	 * @var integer
	 */
	protected $iscontact = 0;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft
	 * @lazy
	 */
	protected $reference;

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getSurname() {
		return $this->surname;
	}

	public function setSurname($surname) {
		$this->surname = $surname;
	}

	public function getPrename() {
		return $this->prename;
	}

	public function setPrename($prename) {
		$this->prename = $prename;
	}

	public function getPictures() {
		return $this->pictures;
	}

	public function setPictures($pictures) {
		$this->pictures = $pictures;
	}

	public function getRank() {
		return $this->rank;
	}

	public function setRank($rank) {
		$this->rank = $rank;
	}

	public function getHeadline() {
		return $this->headline;
	}

	public function setHeadline($headline) {
		$this->headline = $headline;
	}

	public function getMotivation() {
		return $this->motivation;
	}

	public function setMotivation($motivation) {
		$this->motivation = $motivation;
	}

	public function getBirthday() {
		return $this->birthday;
	}

	public function setBirthday($birthday) {
		$this->birthday = $birthday;
	}

	public function getMail() {
		return $this->mail;
	}

	public function setMail($mail) {
		$this->mail = $mail;
	}

	public function getStreet() {
		return $this->street;
	}

	public function setStreet($street) {
		$this->street = $street;
	}

	public function getCity() {
		return $this->city;
	}

	public function setCity($city) {
		$this->city = $city;
	}

	public function getIscontact() {
		return $this->iscontact;
	}

	public function setIscontact($iscontact) {
		$this->iscontact = $iscontact;
	}

	public function setTelephone($telephone) {
		$this->telephone = $telephone;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function setMobilephone($mobilephone) {
		$this->mobilephone = $mobilephone;
	}

	public function getMobilephone() {
		return $this->mobilephone;
	}

	public function setReference($reference) {
		$this->reference = $reference;
	}

	public function getReference() {
		return $this->reference;
	}
}
?>
