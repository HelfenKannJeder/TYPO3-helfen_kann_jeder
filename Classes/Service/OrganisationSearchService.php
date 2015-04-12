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
 * Helper function to search an organisation.
 *
 * @author Valentin Zickner
 */
class OrganisationSearchService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationRepository
	 * @inject
	 */
	protected $organisationRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\GroupRepository
	 * @inject
	 */
	protected $groupRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\GoogleMapsService
	 * @inject
	 */
	protected $googleMapsService;

	public function findOrganisations($persLat, $persLng, $questionYes, $questionNo) {
		$organisationLists = $this->organisationRepository->findOrganisationNearLocation($persLat, $persLng);

		$organisationsNear = array();
		$organisationIds = array();
		foreach ($organisationLists as $organisation) {
			if (!$organisation->getOrganisationtype()->getHideInResult()) {
				$organisationIds[] = $organisation->getUid();
				$organisationsNear[$organisation->getUid()] =  $organisation;
			}
		}

		$organisationsVoting = $this->groupRepository->findByGroupMappingWithAnswersAndOrganisation($questionYes,
			$questionNo, $organisationIds);
		foreach ($organisationsVoting as $key => $voting) {
			$organisationsVoting[$key]['object'] = $organisationsNear[$voting['organisation']];
		}

		return $organisationsVoting;
	}

	public function normOrganisationGrade($organisations, $min, $max) {
		for ($i = count($organisations) - 1; $i >= 0; $i--) {
			if ($i >= 10) {
				unset($organisations[$i]);
			} else {
				if (isset($organisations[$i]['grade'])) {
					$organisations[$i]['grade'] = ($organisations[$i]['grade'] - $min) / $max * 100;
				}
			}
		}
		return $organisations;
	}

	public function createOrganisationObjects($votings, $persLat, $persLng, $maxDistance, $uriBuilder) {
		$gradeMin = NULL;
		$gradeMax = NULL;

		$organisations = array();
		$organisationTypes = array();

		foreach ($votings as $voting) {
			$organisation = $voting['object'];

			$grade = round($voting['gradesum']);
			if ($gradeMin != NULL) {
				$gradeMin = min($grade, $gradeMin);
			} else {
				$gradeMin = $grade;
			}
			$gradeMax = max($grade, $gradeMax);

			$distance = $this->googleMapsService->calculateDistance($organisation, $persLat, $persLng);

			if ($distance <= $maxDistance || $distance == -1) {
				if (!$organisation->getIsDummy()) {
					$organisationTypes[] = $organisation->getOrganisationtype()->getUid();
				}
				$organisations[] = $this->buildOrganisationInfo($organisation, $grade, $distance, $uriBuilder);

			}
		}

		foreach ($organisations as $key => $info) {
			if ($info['is_dummy'] == 1 && in_array($info['organisationtype'], $organisationTypes)) {
				unset($organisations[$key]);
			}
		}

		usort($organisations, array(&$this, 'sortOrganisations'));
		return array($organisations, $gradeMin, $gradeMax);
	}

	protected function buildOrganisationInfo($organisation, $grade, $distance, $uriBuilder) {
		if ($organisation == NULL) {
			return NULL;
		}

		return array(
			'uid' => $organisation->getUid(),
			'name' => $organisation->getName(),
			'organisationtype' => $organisation->getOrganisationtype()->getUid(),
			'description' => $organisation->getDescription(),
			'grade' => $grade,
			'link' => call_user_func($uriBuilder, $organisation->getUid()),
			'distance' => $distance,
			'is_dummy' => $organisation->getIsDummy()
		);
	}

	protected function sortOrganisations($first, $second) {
		if ($first['grade'] == $second['grade']) {
			return ($first['distance'] > $second['distance']) ? 1 : -1;
		}
		return ($first['grade'] > $second['grade']) ? -1 : 1;
	}
}
