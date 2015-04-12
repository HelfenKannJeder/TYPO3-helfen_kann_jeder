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
 * Organisation draft repository for managing new and modified organisations.
 *
 * @author Valentin Zickner
 */
class OrganisationDraftRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	public function findBySupporterAndRequest(\Querformatik\HelfenKannJeder\Domain\Model\Supporter $supporter) {
		$query = $this->createQuery();
		return $query->matching(
				$query->equals('supporter', $supporter)
			)
			->setOrderings(array('request' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
				'requesttime' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING))
			->execute();
	}

	public function findUncompeletedRegistrations($lastRemind = -14) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('request', 0),
				$query->equals('reference', 0),
				$query->logicalOr(
					$query->logicalAnd(
						$query->lessThan('remind_last', time() + ($lastRemind * 86400)),
						$query->equals('remind_count', 0)
					),
					$query->logicalAnd(
						$query->lessThan('remind_last', time() + ($lastRemind * 2 * 86400)),
						$query->equals('remind_count', 1)
					),
					$query->logicalAnd(
						$query->lessThan('remind_last', time() + ($lastRemind * 4 * 86400)),
						$query->equals('remind_count', 2)
					)
				),
				$query->lessThan('crdate', time() + ($lastRemind * 86400))
			)
		)->execute();
	}
}
