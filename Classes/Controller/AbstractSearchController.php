<?php
namespace Querformatik\HelfenKannJeder\Controller;

class AbstractSearchController
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	protected $gradeMin = null;
	protected $gradeMax = null;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\GoogleMapsService
	 * @inject
	 */
	protected $googleMapsService;

	protected function createOrganisationObjectsForTemplate($organisationsNear, $organisationsVoting, $persLat, $persLng) {
		$organisations = array();
		$organisationTypes = array();

		foreach ($organisationsVoting as $organisation) {
			$uid = $organisation['organisation'];
			$organisationObj = $this->organisationRepository->findByUid($uid);

			if ($organisationObj instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation && 
				$organisationObj->getOrganisationtype() instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType) {

				$isDummy = $organisationsNear[$uid]['is_dummy'];
				if (($persLat == 0 && $persLng == 0) || $isDummy == 1) {
					$distance = -1;
				} else {
					$distance = $this->googleMapsService->approxDistance(	$organisationsNear[$uid][0],
											$organisationsNear[$uid][1],
											$persLat, $persLng
					);
				}
				$grade = round($organisation["gradesum"]);
				if ($this->gradeMin == null || $grade < $this->gradeMin) {
					$this->gradeMin = $grade;
				}
				if ($this->gradeMax == null || $grade > $this->gradeMax) {
					$this->gradeMax = $grade;
				}

				if ($distance <= $this->settings['config']['maxDistance'] || $distance == -1) {
					if ($isDummy == 0) {
						$organisationTypes[] = $organisationsNear[$uid]['organisationtype'];
					}
					$organisations[] = array(
						'uid' => $uid,
						'name' => $organisationObj->getName(),
						'organisationtype' => $organisationObj->getOrganisationtype()->getUid(),
						'description' => $organisationObj->getDescription(),
						'grade' => $grade,
						'link' => $this->uriBuilder->reset()->setTargetPageUid($this->settings['page']['overview']['detail'])
							->uriFor('detail', array('organisation' => $uid), 'Overview'),
						'distance' => $distance,
						'is_dummy' => $isDummy
					);
				}
			}
		}

		foreach ($organisations as $key => $info) {
			if ($info['is_dummy'] == 1 && in_array($info['organisationtype'], $organisationTypes)) {
				unset($organisations[$key]);
			}
		}

		usort($organisations, array(&$this, "sortOrganisations"));
		return $organisations;
	}

	public function getGradeMin() {
		return $this->gradeMin;
	}

	public function getGradeMax() {
		return $this->gradeMax;
	}

	protected function sortOrganisations($a, $b) {
		if ($a["grade"] == $b["grade"]) {
			return ($a["distance"] > $b["distance"]) ? 1 : -1;
		}
		return ($a["grade"] > $b["grade"]) ? -1 : 1;
	}
}
?>
