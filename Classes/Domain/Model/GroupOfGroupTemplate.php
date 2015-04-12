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
 * HelfenKannJeder Project
 *
 * @description: This class represents an group of group templates. This
 *   can be used by different organisations.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    HelfenKannJeder e.V.
 * @date: 2013-11-09
 */
class GroupOfGroupTemplate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate>
	 * @lazy
	 */
	protected $groupTemplates;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->groupTemplates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function addGroupTemplates($groupTemplate) {
		$this->groupTemplates->attach($groupTemplate);
	}

	public function getGroupTemplates() {
		return $this->groupTemplates;
	}
}
