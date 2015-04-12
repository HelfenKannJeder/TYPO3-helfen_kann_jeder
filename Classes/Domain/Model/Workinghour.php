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
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents working hours of an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-07-06
 */
class Workinghour extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 */
	protected $organisation;

	/**
	 * @var integer
	 */
	protected $day;

	/**
	 * @var integer
	 */
	protected $starttimehour;

	/**
	 * @var integer
	 */
	protected $starttimeminute;

	/**
	 * @var integer
	 */
	protected $stoptimehour;

	/**
	 * @var integer
	 */
	protected $stoptimeminute;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\Group>
	 */
	protected $groups;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Address
	 */
	protected $address;

	/**
	 * @var string
	 */
	protected $addition;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\WorkinghourDraft
	 * @lazy
	 */
	protected $reference;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->groups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setDay($day) {
		$this->day = $day;
	}

	public function getDay() {
		return $this->day;
	}

	public function setStarttimehour($starttimehour) {
		$this->starttimehour = $starttimehour;
	}

	public function getStarttimehour() {
		return $this->starttimehour;
	}

	public function setStarttimeminute($starttimeminute) {
		$this->starttimeminute = $starttimeminute;
	}

	public function getStarttimeminute() {
		return $this->starttimeminute;
	}

	public function setStoptimehour($stoptimehour) {
		$this->stoptimehour = $stoptimehour;
	}

	public function getStoptimehour() {
		return $this->stoptimehour;
	}

	public function setStoptimeminute($stoptimeminute) {
		$this->stoptimeminute = $stoptimeminute;
	}

	public function getStoptimeminute() {
		return $this->stoptimeminute;
	}

	public function getGroups() {
		return clone $this->groups;
	}

	public function addGroup($group) {
		$this->groups->attach($group);
	}

	public function removeGroup($group) {
		$this->groups->detach($group);
	}

	public function removeAllGroups() {
		foreach ($this->groups as $group) {
			$this->groups->detach($group);
		}
	}

	public function setAddress($address) {
		$this->address = $address;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setAddition($addition) {
		$this->addition = $addition;
	}

	public function getAddition() {
		return $this->addition;
	}

	public function setReference($reference) {
		$this->reference = $reference;
	}

	public function getReference() {
		return $this->reference;
	}
}
