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
			$prefix = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . 'overviewlist');
			$arguments = array(
				$prefix => array(
					'action' => 'detail',
					'controller' => 'Overview',
					'organisation' => $organisation["organisation"]
				)
			);

			$organisationObj = $this->organisationRepository->findByUid($organisation["organisation"]);

			// TODO: Rewrite with visitor pattern
			if ($organisationObj instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
				if ($organisationObj->getOrganisationtype() instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType) {
					if (($persLat == 0 && $persLng == 0) || $organisationsNear[$organisation['organisation']]['is_dummy'] == 1) {
						$distance = -1;
					} else {
						$distance = $this->googleMapsService->approxDistance(	$organisationsNear[$organisation["organisation"]][0],
												$organisationsNear[$organisation["organisation"]][1],
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

					if ($distance <= 20 || $distance == -1) {
						if ($organisationsNear[$organisation['organisation']]['is_dummy'] == 0) {
							$organisationTypes[] = $organisationsNear[$organisation["organisation"]]['organisationtype'];
						}
						$organisations[] = array(
                                                
							"uid"=>$organisation["organisation"],
							"name"=>$organisationObj->getName(),
							"organisationtype"=>$organisationObj->getOrganisationtype()->getUid(),
							"description"=>$organisationObj->getDescription(),
							"grade"=>$grade,
							"link"=>$this->uriBuilder->reset()->setTargetPageUid(9)->setArguments($arguments)->uriFor('', array()), // TODO dynamic
							"distance"=> $distance,
							'is_dummy' => $organisationsNear[$organisation['organisation']]['is_dummy']
						);
					}
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
