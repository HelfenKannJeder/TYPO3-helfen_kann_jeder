<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-11-28
 */
class OrganisationDraft extends Organisation {


	/**
	 * @var integer
	 */
	public static $REQUEST_WAITING = 0;

	/**
	 * @var integer
	 */
	public static $REQUEST_ASKED_FOR_ACTIVATION = 1;

	/**
	 * @var integer
	 */
	public static $REQUEST_ACTIVATED = 2;

	/**
	 * @var integer
	 */
	public static $REQUEST_SCREENING_BY_SUPPORTER = 3;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft>
	 * @lazy
	 */
	protected $contactpersons;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft>
	 *	Persons of this institute.
	 * @lazy
	 * @cascade remove
	 */
	protected $employees;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\AddressDraft
	 */
	protected $defaultaddress;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\AddressDraft>
	 * @lazy
	 * @cascade remove
	 */
	protected $addresses;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\GroupDraft>
	 * @lazy
	 */
	protected $groups;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\WorkinghourDraft>
	 * @lazy
	 */
	protected $workinghours;

	/**
	 * @var integer
	 */
	protected $request;

	/**
	 * @var integer
	 */
	protected $requesttime;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Supporter
	 */
	protected $supporter;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 * @lazy
	 */
	protected $reference;

	/**
	 * @var integer
	 */
	protected $remindLast;

	/**
	 * @var integer
	 */
	protected $remindCount;

	/**
	 * @var integer
	 */
	protected $tstamp;

	public function getRequest() {
		return $this->request;
	}

	public function setRequest($request) {
		$this->request = $request;
	}

	public function getRequesttime() {
		return $this->requesttime;
	}

	public function setRequesttime($requesttime) {
		$this->requesttime = $requesttime;
	}

	public function getSupporter() {
		return $this->supporter;
	}

	public function setSupporter($supporter) {
		$this->supporter = $supporter;
	}

	public function getRemindLast() {
		return $this->remindLast;
	}

	public function setRemindLast($remindLast) {
		$this->remindLast = $remindLast;
	}

	public function getRemindCount() {
		return $this->remindCount;
	}

	public function setRemindCount($remindCount) {
		$this->remindCount = $remindCount;
	}

	public function getControlHash() {
		return substr(md5("Unique hash with info: ".$this->getName()." and created at ".$this->getCrdate()." and additionally the uid: ".$this->getUid()." end of information"),0,10);
	}

	public function getTstamp() {
		return $this->tstamp;
	}
}
?>
