<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an backer.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-09-22
 */
class Backer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $degree;

	/**
	 * @var string
	 */
	protected $prename;

	/**
	 * @var string
	 */
	protected $surname;

	/**
	 * @var string
	 */
	protected $company;

	/**
	 * @var string
	 */
	protected $status;

	/**
	 * @var string
	 */
	protected $thumbnail;

	/**
	 * @var string
	 */
	protected $picture;

	/**
	 * @var integer
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var integer
	 */
	protected $since;

	/**
	 * @return void
	 */
	public function setDegree($degree) {
		$this->degree = $degree;
	}

	public function getDegree() {
		return $this->degree;
	}

	public function setPrename($prename) {
		$this->prename = $prename;
	}

	public function getPrename() {
		return $this->prename;
	}

	public function setSurname($surname) {
		$this->surname = $surname;
	}

	public function getSurname() {
		return $this->surname;
	}

	public function setCompany($company) {
		$this->company = $company;
	}

	public function getCompany() {
		return $this->company;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setThumbnail($thumbnail) {
		$this->thumbnail = $thumbnail;
	}

	public function getThumbnail() {
		return $this->thumbnail;
	}

	public function setPicture($picture) {
		$this->picture = $picture;
	}

	public function getPicture() {
		return $this->picture;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setSince($since) {
		$this->since = $since;
	}

	public function getSince() {
		return $this->since + 86400 / 2;
	}
}
