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
 * Represents an employee of an organisation
 *
 * @author Valentin Zickner
 */
class EmployeeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findByOrganisationUid($organisationUid) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation', $organisationUid))
			->setOrderings( array('prename' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}

	public function findByOrganisationUidWithStatement($organisationUid) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('organisation', $organisationUid),
					$query->logicalNot($query->equals('motivation', '')),
					$query->logicalNot($query->equals('uid', 28))
				)
			)
			->setOrderings( array('prename' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}

}
