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
 * @description: This class represents an helf-o-mat catalog.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-06-15
 */
class HelfOMatQuestion extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\HelfOMat
	 */
	protected $helfomat;

	/**
	 * @var string
	 */
	protected $question;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupPositive;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupNegative;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupPositivenot;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<GroupOfGroupTemplate>
	 * @lazy
	 */
	protected $groupNegativenot;

	/**
	 * @var integer
	 */
	protected $sort;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->groupPositive = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->groupNegative = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->groupPositivenot = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->groupNegativenot = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	public function setHelfomat($helfomat) {
		$this->helfomat = $helfomat;
	}

	public function getHelfomat() {
		return $this->helfomat;
	}

	public function setQuestion($question) {
		$this->question = $question;
	}

	public function getQuestion() {
		return $this->question;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}



	public function setGroupPositive($groupPositive) {
		$this->groupPositive = $groupPositive;
	}

	public function getGroupPositive() {
		return $this->groupPositive;
	}

	public function addGroupPositive($groupPositive) {
		$this->groupPositive->attach($groupPositive);
	}

	public function removeGroupPositive($groupPositive) {
		$this->groupPositive->detach($groupPositive);
	}

	public function setGroupNegative($groupNegative) {
		$this->groupNegative = $groupNegative;
	}

	public function getGroupNegative() {
		return $this->groupNegative;
	}

	public function addGroupNegative($groupNegative) {
		$this->groupNegative->attach($groupNegative);
	}

	public function removeGroupNegative($groupNegative) {
		$this->groupNegative->detach($groupNegative);
	}

	public function setGroupPositivenot($groupPositivenot) {
		$this->groupPositivenot = $groupPositivenot;
	}

	public function getGroupPositivenot() {
		return $this->groupPositivenot;
	}

	public function addGroupPositivenot($groupPositivenot) {
		$this->groupPositivenot->attach($groupPositivenot);
	}

	public function removeGroupPositivenot($groupPositivenot) {
		$this->groupPositivenot->detach($groupPositivenot);
	}

	public function setGroupNegativenot($groupNegativenot) {
		$this->groupNegativenot = $groupNegativenot;
	}

	public function getGroupNegativenot() {
		return $this->groupNegativenot;
	}

	public function addGroupNegativenot($groupNegativenot) {
		$this->groupNegativenot->attach($groupNegativenot);
	}

	public function removeGroupNegativenot($groupNegativenot) {
		$this->groupNegativenot->detach($groupNegativenot);
	}

	public function getSort() {
		return $this->sort;
	}

	public function setSort($sort) {
		$this->sort = $sort;
	}
}
