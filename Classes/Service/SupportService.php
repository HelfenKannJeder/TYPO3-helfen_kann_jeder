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

/**
 * SupportService finds the responsible supporter for a given location
 *
 * @author Valentin Zickner
 */
class SupportService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\SupporterRepository
	 * @inject
	 */
	private $supporterRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
	 * @inject
	 */
	private $frontendUserGroupRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Supporter
	 */
	private $defaultSupporter;

	private $searchedGroups;
	private $allSupporter;

	/**
	 * Set the default supporter to use in case of no other supporter.
	 *
	 * @return void
	 */
	public function setDefaultSupporter($defaultSupporter) {
		$this->defaultSupporter = $defaultSupporter;
	}

	/**
	 * @param array location Location to search the supporter for
	 * @param integer Group of the supporter
	 * @param organisationtype Type of the supporter
	 * @return Supporter for the given organisation and location.
	 */
	public function findSupporter($location, $supporterGroupId, $organisationtype = NULL) {
		$this->allSupporter = array();
		$this->searchedGroups = array();
		$searchIds = array($supporterGroupId);
		if ($organisationtype instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType
			&& $organisationtype->getFegroup() instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup) {
			$searchIds[] = $organisationtype->getFegroup()->getUid();
		}
		if (is_array($location) && count($location) > 0) {
			$firstLocation = current($location);
			foreach ($firstLocation as $typeLevel => $nameLevel) {
				if (in_array($typeLevel, array('locality', 'administrative_area_level_1', 'administrative_area_level_2', 'country'))) {
					$groups = $this->frontendUserGroupRepository->findByTitle((string) $nameLevel . ' (' . $typeLevel . ')');
					$this->searchedGroups[] = (string) $nameLevel . ' (' . $typeLevel . ')';
					if (count($groups) != 0) {
						$group = $groups[0];
						$supporter = $this->supporterRepository->findByUsergroups(array_merge(array($group->getUid()), $searchIds));
						if (count($supporter) > 0) {
							break;
						}
					}
					$groups = $this->frontendUserGroupRepository->findByTitle((string) $nameLevel);
					$this->searchedGroups[] = (string) $nameLevel;
					if (count($groups) != 0) {
						$group = $groups[0];
						$supporter = $this->supporterRepository->findByUsergroups(array_merge(array($group->getUid()), $searchIds));
						if (count($supporter) > 0) {
							break;
						}
					}
				}
			}
			$this->allSupporter = $supporter;
			$supporter = $supporter[mt_rand(0, count($supporter) - 1)];
		} else {
			$supporter = NULL;
		}

		if (!($supporter instanceof \Querformatik\HelfenKannJeder\Domain\Model\Supporter)) {
			$supporter = $this->supporterRepository->findByUid($this->defaultSupporter);
		}
		return $supporter;
	}

	public function getSearchedGroups() {
		return $this->searchedGroups;
	}

	public function getAllSupporter() {
		return $this->allSupporter;
	}
}
