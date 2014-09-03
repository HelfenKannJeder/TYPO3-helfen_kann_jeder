<?php
class Tx_HelfenKannJeder_Controller_AbstractSearchController
	extends Tx_Extbase_MVC_Controller_ActionController {
	protected $gradeMin = null;
	protected $gradeMax = null;

	/**
	 * @var Tx_HelfenKannJeder_Service_GoogleMapsService
	 * @inject
	 */
	protected $googleMapsService;

	protected function createOrganisationObjectsForTemplate($organisationsNear, $organisationsVoting, $persLat, $persLng) {
		$organisations = array();
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

			if ($organisationObj instanceof Tx_HelfenKannJeder_Domain_Model_Organisation) {
				if ($organisationObj->getOrganisationtype() instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationType) {
					$distance = $this->googleMapsService->approxDistance(	$organisationsNear[$organisation["organisation"]][0],
											$organisationsNear[$organisation["organisation"]][1],
											$persLat, $persLng
					);
					$grade = round($organisation["gradesum"]);
					if ($this->gradeMin == null || $grade < $this->gradeMin) {
						$this->gradeMin = $grade;
					}
					if ($this->gradeMax == null || $grade > $this->gradeMax) {
						$this->gradeMax = $grade;
					}

					if ($distance <= 20) {
						$organisations[] = array(
                                                
							"uid"=>$organisation["organisation"],
							"name"=>$organisationObj->getName(),
							"organisationtype"=>$organisationObj->getOrganisationtype()->getUid(),
							"description"=>$organisationObj->getDescription(),
							"grade"=>$grade,
							"link"=>$this->uriBuilder->reset()->setTargetPageUid(9)->setArguments($arguments)->uriFor('', array()), // TODO dynamic
							"distance"=> $distance
						);
					}
				}
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
