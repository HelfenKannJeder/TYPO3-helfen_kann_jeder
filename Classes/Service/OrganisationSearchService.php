<?php
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

	public function findOrganisations($persLat, $persLng, $answer, $maxDistance, $uriBuilder) {
		$organisationLists = $this->organisationRepository->findOrganisationNearLocation($persLat, $persLng);

		$organisationsNear = array();
		$organisationIds = array();
		foreach ($organisationLists as $organisation) {
			if (!$organisation->getOrganisationtype()->getHideInResult()) {
				$organisationIds[] = $organisation->getUid();
				$organisationsNear[$organisation->getUid()] =  $organisation;
			}
		}

		$questionYes = array_keys($answer, 1);
		$questionNo = array_keys($answer, 2);

		$organisationsVoting = $this->groupRepository->findByGroupMappingWithAnswersAndOrganisation($questionYes,
			$questionNo, $organisationIds);

		list($organisations, $gradeMin, $gradeMax) = $this->createOrganisationObjects($organisationsNear,
			$organisationsVoting, $persLat, $persLng, $maxDistance, $uriBuilder);
		$min = $gradeMin - 10;
		$max = $gradeMax - $min;

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

	public function createOrganisationObjects($allOrganisations, $votings, $persLat, $persLng, $maxDistance, $uriBuilder) {
		$gradeMin = NULL;
		$gradeMax = NULL;

		$organisations = array();
		$organisationTypes = array();

		foreach ($votings as $voting) {
			$organisation = $allOrganisations[$voting['organisation']];

			$grade = round($voting['gradesum']);
			if ($gradeMin != NULL) {
				$gradeMin = min($grade, $gradeMin);
			} else {
				$gradeMin = $grade;
			}
			$gradeMax = max($grade, $gradeMax);

			$distance = $this->calculateDistance($persLat, $persLng, $organisation);

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

	protected function calculateDistance($latitude, $longitude, $organisation) {
		if (($latitude == 0 && $longitude == 0) || $organisation->getIsDummy()) {
			$distance = -1;
		} else {
			$distance = $this->googleMapsService->approxDistance(
				$organisation->getLatitude(), $organisation->getLongitude(), $latitude, $longitude
			);
		}
		return $distance;
	}

	protected function buildOrganisationInfo($organisation, $grade, $distance, $uriBuilder) {
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
