<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an log entry.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-04-11
 */
class Log
		extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $feuser;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 */
	protected $organisation;

	public function __construct() {
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	public function getMessage() {
		return $this->message;
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
}
?>
