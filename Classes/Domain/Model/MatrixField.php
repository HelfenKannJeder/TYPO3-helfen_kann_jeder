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
 * "Helfen KAnn Jeder" Project
 *
 * @description: This class represents a matrix field.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-05-13
 */
class MatrixField extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Matrix
	 */
	protected $matrix;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 * 	The organisation of this layer.
	 */
	protected $organisation;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Activity
	 */
	protected $activity;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\ActivityField
	 */
	protected $activityfield;

	/**
	 * @var integer
	 * 	The grade of this connection.
	 */
	protected $grade;

	/**
	 * @return void
	 */
	public function __construct($matrix, $organisation, $activity, $activityfield, $grade) {
		$this->setMatrix($matrix);
		$this->setOrganisation($organisation);
		$this->setActivity($activity);
		$this->setActivityfield($activityfield);
		$this->setGrade($grade);
	}

	public function setMatrix($matrix) {
		$this->matrix = $matrix;
	}

	public function getMatrix() {
		return $this->matrix;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setActivity($activity) {
		$this->activity = $activity;
	}

	public function getActivity() {
		return $this->activity;
	}

	public function setActivityfield($activityfield) {
		$this->activityfield = $activityfield;
	}

	public function getActivityfield() {
		return $this->activityfield;
	}

	public function setGrade($grade) {
		$this->grade = $grade;
	}

	public function getGrade() {
		return $this->grade;
	}
}
