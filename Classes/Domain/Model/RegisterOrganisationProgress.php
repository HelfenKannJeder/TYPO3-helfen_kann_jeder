<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This is an assistant class which stores user information while the user try to register an account.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-10-07
 */
class RegisterOrganisationProgress extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var integer
	 */
	protected $modified = 0;

	/**
	 * @var string
	 */
	protected $sessionid = '';

	/**
	 * @var boolean
	 * @validate Boolean(is=true)
	 */
	protected $agreement = FALSE;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType
	 * @validate NotEmpty
	 */
	protected $organisationtype = NULL;

	/**
	 * @var string
	 * @validate StringLength(minimum=3, maximum=50)
	 */
	protected $typename = '';

	/**
	 * @var string
	 * @validate StringLength(minimum=1, maximum=5)
	 */
	protected $typeacronym = '';

	/**
	 * @var string
	 * @validate StringLength(minimum=3, maximum=500)
	 */
	protected $typedescription = '';

	/**
	 * @var string
	 * @validate StringLength(minimum=1, maximum=255)
	 */
	protected $city = '';

	/**
	 * @var float
	 */
	protected $longitude = 0.0000;

	/**
	 * @var float
	 */
	protected $latitude = 0.0000;

	/**
	 * @var string
	 */
	protected $department = '';

	/**
	 * @var string
	 */
	protected $username = '';

	/**
	 * @var string
	 */
	protected $organisationname = '';

	/**
	 * @var string
	 */
	protected $password = '';

	/**
	 * @var string
	 */
	protected $password2 = '';

	/**
	 * @var boolean
	 */
	protected $passwordSaved = FALSE;

	/**
	 * @var string
	 * @validate EmailAddress
	 */
	protected $mail = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $feuser = NULL;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 */
	protected $organisation = NULL;

	/**
	 * @var integer
	 */
	protected $laststep = 0;

	/**
	 * @var integer
	 */
	protected $finisheduntil = 0;

	/**
	 * @var string
	 */
	protected $mailHash = '';

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Supporter
	 */
	protected $supporter;

	/**
	 * @var string
	 */
	protected $surname;

	/**
	 * @var string
	 */
	protected $prename;

	/**
	 * @var string
	 */
	protected $imageFolder = 'uploads/tx_helfenkannjeder/';

	/**
	 * @return void
	 */
	public function __construct($sessionid = '') {
		$this->sessionid = $sessionid;
		$this->setModified(time());
	}

	public function setModified($modified) {
		$this->modified = $modified;
	}

	public function getModified() {
		return $this->modified;
	}

	public function getSessionid() {
		return $this->sessionid;
	}

	public function setAgreement($agreement) {
		$this->agreement = $agreement;
		$this->setModified(time());
	}

	public function getAgreement() {
		return $this->agreement;
	}

	public function setOrganisationtype($organisationtype) {
		$this->organisationtype = $organisationtype;
		$this->setModified(time());
	}

	public function getOrganisationtype() {
		return $this->organisationtype;
	}

	public function setTypename($typename) {
		$this->typename = $typename;
	}

	public function getTypename() {
		return $this->typename;
	}

	public function setTypeacronym($typeacronym) {
		$this->typeacronym = $typeacronym;
	}

	public function getTypeacronym() {
		return $this->typeacronym;
	}

	public function setTypedescription($typedescription) {
		$this->typedescription = $typedescription;
	}

	public function getTypedescription() {
		return $this->typedescription;
	}

	public function setCity($city) {
		$this->city = trim($city);
		$this->setModified(time());
	}

	public function getCity() {
		return $this->city;
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

	public function setDepartment($department) {
		$this->department = $department;
		$this->setModified(time());
	}

	public function getDepartment() {
		return $this->department;
	}

	public function setOrganisationname($organisationname) {
		$this->organisationname = $organisationname;
	}

	public function getOrganisationname() {
		return $this->organisationname;
	}

	public function setUsername($username) {
		$this->username = $username;
		$this->setModified(time());
	}

	public function getUsername() {
		return $this->username;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword2($password2) {
		$this->password2 = $password2;
	}

	public function getPassword2() {
		return $this->password2;
	}

	public function setPasswordSaved($passwordSaved) {
		$this->passwordSaved = $passwordSaved;
	}

	public function getPasswordSaved() {
		return $this->passwordSaved;
	}

	public function setMail($mail) {
		$this->mail = $mail;
	}

	public function getMail() {
		return $this->mail;
	}

	public function setFeuser($feuser) {
		$this->feuser = $feuser;
	}

	public function getFeuser() {
		return $this->feuser;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setLaststep($laststep) {
		$this->laststep = $laststep;
	}

	public function getLaststep() {
		return $this->laststep;
	}

	public function setFinisheduntil($finisheduntil) {
		if ($finisheduntil > $this->finisheduntil) {
			$this->finisheduntil = $finisheduntil;
		}
	}

	public function getFinisheduntil() {
		return $this->finisheduntil;
	}

	public function getMailHash() {
		return $this->mailHash;
	}

	public function setMailHash($mailHash) {
		$this->mailHash = $mailHash;
	}

	public function getSupporter() {
		return $this->supporter;
	}

	public function setSupporter($supporter) {
		$this->supporter = $supporter;
	}

	public function setSurname($surname) {
		$this->surname = $surname;
	}

	public function getSurname() {
		return $this->surname;
	}

	public function setPrename($prename) {
		$this->prename = $prename;
	}

	public function getPrename() {
		return $this->prename;
	}
}
