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
namespace Querformatik\HelfenKannJeder\Service;

class MatrixService implements \TYPO3\CMS\Core\SingletonInterface {
	private $activityList;
	private $matrix;

	public function __construct() {
	}

	public function getActivityList() {
		return $this->activityList;
	}

	public function getMatrix() {
		return $this->matrix;
	}

	public function buildOrganisationMatrix( $organisation) {
		$matrixA = array();
		$activityList = array();
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation
			|| $organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft) {
			foreach ($organisation->getGroups() as $group) {
				$matrix = $group->getMatrix();
				if ($matrix instanceof \Querformatik\HelfenKannJeder\Domain\Model\Matrix) {
					foreach ($matrix->getMatrixfields() as $matrixfield) {
						if ($matrixfield > 0) {
							if ($matrixfield->getActivityfield() instanceof \Querformatik\HelfenKannJeder\Domain\Model\Activityfield &&
								$matrixfield->getActivity() instanceof \Querformatik\HelfenKannJeder\Domain\Model\Activity) {
								$activityfield = $matrixfield->getActivityfield()->getUid();
								$activity = $matrixfield->getActivity()->getUid();
								if (!isset($matrixA[$activityfield])) {
									$matrixA[$activityfield] = array();
								}
								if (!isset($matrixA[$activityfield][$activity]) || $matrixA[$activityfield][$activity] < $matrixfield) {
									$matrixA[$activityfield][$activity] = $matrixfield;
								}
								$activityList[] = $activity;
							}
						}
					}
				} else {
				}
			}
		}
		$this->matrix = $matrixA;
		$this->activityList = $activityList;
	}
}
?>
