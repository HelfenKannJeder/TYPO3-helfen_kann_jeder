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
 * This class represents a group draft, part of an organisation in draft mode.
 *
 * @author Valentin Zickner
 */
class GroupDraftRepository extends GroupRepository {

	// TODO: This method seems to be similar to EmployeeDraftRepository.
	public function findByOrganisationAndTemplate($organisation, $template) {
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$organisationUid = $organisation->getUid();
		} elseif (is_int($organisation)) {
			$organisationUid = $organisation;
		} else {
			return FALSE;
		}

		if ($template instanceof \Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate) {
			$templateUid = $template->getUid();
		} elseif (is_int($template)) {
			$templateUid = $template;
		} else {
			return FALSE;
		}

		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('organisation', $organisationUid),
				$query->equals('template', $templateUid)
			))
			->setOrderings( array('sort' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}

	public function findByOrganisationGroupListByTemplate($organisation) {
		$groupListByTemplate = array();
		if ($organisation != NULL) {
			$groupList = $this->findByOrganisation($organisation);
			foreach ($groupList as $group) {
				if ($group->getTemplate() instanceof \Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate) {
					$groupListByTemplate[$group->getTemplate()->getUid()] = $group;
				}
			}
		}
		return $groupListByTemplate;
	}

	// TODO: This method seems to be similar to EmployeeDraftRepository.
	public function findByOrganisationUid($organisationUid) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation', $organisationUid))
			->setOrderings( array('sort' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}
}
