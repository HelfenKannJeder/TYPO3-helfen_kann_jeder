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
 * @description: This class represents a matrix.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-05-13
 */
class Matrix extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var string
	 * 	Name of the matrix
	 */
	protected $name = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $feuser;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Organisation
	 */
	protected $organisation;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\MatrixField>
	 * @cascade remove
	 */
	protected $matrixfields;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->matrixfields = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}

	public function getOrganisation() {
		return $this->organisation;
	}

	public function setFeuser($feuser) {
		$this->feuser = $feuser;
	}

	public function getFeuser() {
		return $this->feuser;
	}

	public function getMatrixfields() {
		return clone $this->matrixfields;
	}

	public function getMatrixfield($activityfield, $activity) {
		foreach ($this->matrixfields as $field) {
			if ($field instanceof MatrixField
				&& $field->getActivity()->getUid() == $activity
				&& $field->getActivityfield()->getUid() == $activityfield) {
				return $field;
			}
		}
		return NULL;
	}

	public function addMatrixfield($matrixfield) {
		$this->matrixfields->attach($matrixfield);
	}

	public function removeMatrixfield($matrixfield) {
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$storage->attach($matrixfield);
		$this->matrixfields->removeAll($storage);
	}
}
