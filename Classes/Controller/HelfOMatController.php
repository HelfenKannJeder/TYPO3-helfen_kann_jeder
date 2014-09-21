<?php
namespace Querformatik\HelfenKannJeder\Controller;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class is the controller of Helf-O-Mat.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-06-15
 */
class HelfOMatController extends AbstractSearchController {

	protected $helfOMatRepository;
	protected $groupRepository;
	protected $matrixFieldRepository;
	protected $organisationRepository;


	public function initializeAction() {
		$this->helfOMatRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\HelfOMatRepository');
		$this->groupRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupRepository');
		$this->matrixFieldRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\MatrixFieldRepository');
		$this->organisationRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat
	 */
	public function quizAction(\Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat = null) {
		if ($helfOMat == null && isset($this->settings["helfomat"]["default"])) {
			$helfOMat = $this->helfOMatRepository->findByUid($this->settings["helfomat"]["default"]);
		}

		$this->view->assign("helfOMat", $helfOMat);
	}


	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat
	 * @param array $answer
	 *		This is from the structure {questionId} => answer, where the questionId is the unique
	 *		identifier from the question and the answer is an integer between 0 and 2, where
	 *			0 => neutral
	 *			1 => yes
	 *			2 => no
	 */
	public function groupResultAction(\Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat, $answer) {
		$organisations = $this->calculateGroupResult($answer);

		$this->view->assign("answer", $answer);
		$this->view->assign("helfOMat", $helfOMat);
		$this->view->assign('normGradeToMax', 1/100);
		$this->view->assign("organisations", $organisations);
	}


	/**
	 * @param array $answer
	 *		This is from the structure {questionId} => answer, where the questionId is the unique
	 *		identifier from the question and the answer is an integer between 0 and 2, where
	 *			0 => neutral
	 *			1 => yes
	 *			2 => no
	 */
	public function jsonGroupResultAction($answer) {
		$organisations = $this->calculateGroupResult($answer);

		return json_encode($organisations);
	}

	/**
	 * @param array $answer
	 *		This is from the structure {questionId} => answer, where the questionId is the unique
	 *		identifier from the question and the answer is an integer between 0 and 2, where
	 *			0 => neutral
	 *			1 => yes
	 *			2 => no
	 * @return array	Array of organisations
	 */
	private function calculateGroupResult($answer) {
		list($persLat, $persLng, $age) = $this->parseCookie();

		list($organisationsNear, $matrices) = $this->groupRepository->findOrganisationMatricesNearLatLng($persLat, $persLng, $age);
		$organisationIds = array_keys($organisationsNear);

		$questionYes = array_keys($answer, 1);
		$questionNo = array_keys($answer, 2);

		$organisationsVoting = $this->groupRepository->findByGroupMappingWithAnswersAndOrganisation($questionYes, $questionNo, $organisationIds);

		$organisations = $this->createOrganisationObjectsForTemplate($organisationsNear, $organisationsVoting, $persLat, $persLng);
		$min = $this->getGradeMin()-10;
		$max = $this->getGradeMax()-$min;

		for ($i = count($organisations)-1; $i >= 0; $i--) {
			if ($i >= 10) {
				unset($organisations[$i]);
			} else {
				if (isset($organisations[$i]['grade'])) {
					$organisations[$i]['grade'] = ($organisations[$i]['grade']-$min)/$max*100;
				}
			}
		}
		return $organisations;
	}

	/**
	 * Parse cookie to get pers lat, pers lng and age.
	 */
	public function parseCookie() {
		$persLat = 0.0;
		$persLng = 0.0;
		$age = 18;
		if (isset($_COOKIE["hkj_info"])) {
			$cookieInfo = explode("##1##", $_COOKIE["hkj_info"]);
			if (count($cookieInfo) >= 5 && is_numeric($cookieInfo[0]) && is_numeric($cookieInfo[1])) {
				$persLat = (float)$cookieInfo[0];
				$persLng = (float)$cookieInfo[1];
			}
 			if (count($cookieInfo) >= 5 && is_numeric($cookieInfo[4])) {
				$age = (int)$cookieInfo[4];
			}
		}

		return array($persLat, $persLng, $age);
	}





	private function getObjectStorageUids($storage) {
		$uids = array();
		foreach ($storage as $entry) {
			$uids[] = $entry->getUid();
		}
		return $uids;
	}

}
?>
