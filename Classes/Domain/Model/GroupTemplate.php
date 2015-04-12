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
 * @description: This class represents an activity field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-12-02
 */
class GroupTemplate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $suggestion;

	/**
	 * @var integer
	 */
	protected $minimumAge;

	/**
	 * @var integer
	 */
	protected $maximumAge;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Matrix
	 */
	protected $matrix;

	/**
	 * @var boolean
	 */
	protected $isoptional;

	/**
	 * @var boolean
	 */
	protected $isdefault;

	/**
	 * @var boolean
	 */
	protected $isfeature;

	/**
	 * @var integer
	 */
	protected $sort;

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setSuggestion($suggestion) {
		$this->suggestion = $suggestion;
	}

	public function getSuggestion() {
		return $this->suggestion;
	}

	public function setMinimumAge($minimumAge) {
		$this->minimumAge = $minimumAge;
	}

	public function getMinimumAge() {
		return $this->minimumAge;
	}

	public function setMaximumAge($maximumAge) {
		$this->maximumAge = $maximumAge;
	}

	public function getMaximumAge() {
		return $this->maximumAge;
	}

	public function setMatrix($matrix) {
		$this->matrix = $matrix;
	}

	public function getMatrix() {
		return $this->matrix;
	}

	public function getIsoptional() {
		return $this->isoptional;
	}

	public function setIsoptional($isoptional) {
		$this->isoptional = $isoptional;
	}

	public function getIsdefault() {
		return $this->isdefault;
	}

	public function setIsdefault($isdefault) {
		$this->isdefault = $isdefault;
	}

	public function getIsfeature() {
		return $this->isfeature;
	}

	public function setIsfeature($isfeature) {
		$this->isfeature = $isfeature;
	}

	public function setSort($sort) {
		$this->sort = $sort;
	}

	public function getSort() {
		return $this->sort;
	}
}
