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
 * @description: This class represents an organisation type.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-06-19
 */
class OrganisationType extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var integer
	 */
	protected $uid = 0;

	/**
	 * @var string
	 * 	Name of the organisation
	 */
	protected $name = '';

	/**
	 * @var string
	 * 	Name of the organisation
	 */
	protected $namedisplay = '';

	/**
	 * @var string
	 * 	Description of the organisation
	 */
	protected $description = '';

	/**
	 * @var string
	 * 	Acronym of the organisation
	 */
	protected $acronym = '';

	/**
	 * @var string
	 * 	The main picture displayed at the overview.
	 */
	protected $picture;

	/**
	 * @var string
	 * 	Teaser images for the rotating view
	 */
	protected $teaser;

	/**
	 * @var string
	 */
	protected $logos;

	/**
	 * @var boolean
	 */
	protected $pseudo;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\GroupTemplateCategory>
	 * @lazy
	 */
	protected $groupTemplateCategories;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
	 */
	protected $fegroup;

	/**
	 * @var boolean
	 */
	protected $registerable;

	/**
	 * @var boolean
	 */
	protected $hideInResult;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 * @lazy
	 */
	protected $dummyOrganisation;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->groupTemplateCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setNamedisplay($namedisplay) {
		$this->namedisplay = $namedisplay;
	}

	public function getNamedisplay() {
		return $this->namedisplay;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setAcronym($acronym) {
		$this->acronym = $acronym;
	}

	public function getAcronym() {
		return $this->acronym;
	}

	public function setPicture($picture) {
		$this->picture = $picture;
	}

	public function getPicture() {
		return $this->picture;
	}

	public function setTeaser($teaser) {
		$this->teaser = $teaser;
	}

	public function getTeaser() {
		return $this->teaser;
	}

	public function setLogos($logos) {
		$this->logos = $logos;
	}

	public function getLogos() {
		return $this->logos;
	}

	public function setPseudo($pseudo) {
		$this->pseudo = $pseudo;
	}

	public function getPseudo() {
		return (bool)$this->pseudo;
	}

	public function addGroupTemplateCategory($groupTemplateCategory) {
		$this->groupTemplateCategories->attach($groupTemplateCategory);
	}

	public function getGroupTemplateCategories() {
		return $this->groupTemplateCategories;
	}

	public function setFegroup($fegroup) {
		$this->fegroup = $fegroup;
	}

	public function getFegroup() {
		return $this->fegroup;
	}

	public function setRegisterable($registerable) {
		$this->registerable = $registerable;
	}

	public function getRegisterable() {
		return $this->registerable;
	}

	public function setHideInResult($hideInResult) {
		$this->hideInResult = $hideInResult;
	}

	public function getHideInResult() {
		return $this->hideInResult;
	}

	public function setDummyOrganisation(Organisation $dummyOrganisation) {
		$this->dummyOrganisation = $dummyOrganisation;
	}

	public function getDummyOrganisation() {
		return $this->dummyOrganisation;
	}
}
