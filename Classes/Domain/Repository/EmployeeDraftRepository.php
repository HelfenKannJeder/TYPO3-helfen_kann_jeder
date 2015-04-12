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
namespace Querformatik\HelfenKannJeder\Domain\Repository;

/**
 * Representing the draft of an employee
 *
 * @author Valentin Zickner
 */
class EmployeeDraftRepository extends EmployeeRepository {

	// TODO: This is maybe a duplicate of parent method.
	public function findByOrganisationAndUid($organisation, $uid) {
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$organisationUid = $organisation->getUid();
		} elseif (is_int($organisation)) {
			$organisationUid = $organisation;
		} else {
			return FALSE;
		}

		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('organisation', $organisationUid),
				$query->equals('uid', $uid)
			))
			->setLimit(1)
			->execute();
	}


	// TODO: This is maybe a duplicate of parent method.
	public function findByOrganisationUidWithStatement($organisationUid) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('organisation', $organisationUid),
					$query->logicalNot($query->equals('motivation', ''))
				)
			)
			->setOrderings( array('prename' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}
}
