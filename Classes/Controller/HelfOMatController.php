<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class is the controller of Helf-O-Mat.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-06-15
 */
class Tx_HelfenKannJeder_Controller_HelfOMatController
		extends Tx_HelfenKannJeder_Controller_AbstractSearchController {
	protected $helfOMatRepository;
	protected $groupRepository;
	protected $matrixFieldRepository;
	protected $organisationRepository;


	public function initializeAction() {
		$this->helfOMatRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_HelfOMatRepository');
		$this->groupRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupRepository');
		$this->matrixFieldRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_MatrixFieldRepository');
		$this->organisationRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository');
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat
	 */
	public function quizAction(Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat = null) {
		if ($helfOMat == null && isset($this->settings["helfomat"]["default"])) {
			$helfOMat = $this->helfOMatRepository->findByUid($this->settings["helfomat"]["default"]);
		}

		$this->view->assign("helfOMat", $helfOMat);
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat
	 * @param array $answer
	 */
	public function resultAction(Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat, $answer) {
		list($persLat, $persLng, $age) = $this->parseCookie();


		list($activities, $activitiesNot, $activityGroup) = $this->calculateActivitiesAndNot($helfOMat, $answer, $persLat, $persLng, $age);
		$this->view->assign("answer", $answer);
		$this->view->assign("activities", $activities);
		$this->view->assign("activitiesNot", $activitiesNot);
		$this->view->assign("activityGroup", $activityGroup);
		$this->view->assign("helfOMat", $helfOMat);

		list($organisationsNear, $matrices) = $this->groupRepository->findOrganisationMatricesNearLatLng($persLat, $persLng, $age);

		if (count($activities) == 0 && count($activitiesNot) == 0) {
			$organisationsVoting = $organisationsNear;
		} else {
			$organisationsVoting = $this->matrixFieldRepository->findByMatrixFieldAndMatrix(array_merge($activities, $activitiesNot), array(), array_keys($organisationsNear), $matrices, $activitiesNot, $activityGroup, true);
		}

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


		$this->view->assign('normGradeToMax', 1/100);
		$this->view->assign("organisations", $organisations);
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat
	 * @param array $answer
	 *		This is from the structure {questionId} => answer, where the questionId is the unique
	 *		identifier from the question and the answer is an integer between 0 and 2, where
	 *			0 => neutral
	 *			1 => yes
	 *			2 => no
	 */
	public function groupResultAction(Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat, $answer) {
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


		$this->view->assign("answer", $answer);
		$this->view->assign("helfOMat", $helfOMat);
		$this->view->assign('normGradeToMax', 1/100);
		$this->view->assign("organisations", $organisations);
	}

	/**
	 * Parse cookie to get pers lat, pers lng and age.
	 */
	public function parseCookie() {
		$persLat = 49.009227;
		$persLng = 8.403929;
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

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat
	 * @param array $answer
	 */
	public function detailAction(Tx_HelfenKannJeder_Domain_Model_HelfOMat $helfOMat, $answer) {
		$persLat = 49.009227;
		$persLng = 8.403929;
		$age = 18;

		list($activities, $activitiesNot, $activityGroup) = $this->calculateActivitiesAndNot($helfOMat, $answer, $persLat, $persLng, $age);
		$this->view->assign("answer", $answer);

		list($organisationsNear, $matrices) = $this->groupRepository->findOrganisationMatricesNearLatLng($persLat, $persLng, $age);
		$organisationsVoting = $this->matrixFieldRepository->findByMatrixFieldAndMatrix(array_merge($activities, $activitiesNot), array(), array_keys($organisationsNear), $matrices, $activitiesNot, $activityGroup, true);

		$organisationsObj = array();
		$organisationPercent = array();
		foreach ($organisationsVoting as $organisation) {
			$organisationObj = $this->organisationRepository->findByUid($organisation["organisation"]);

			$organisationPercent[$organisation["organisation"]][$organisation["activity"]] = $organisation["grade"];

			if ($organisationObj instanceof Tx_HelfenKannJeder_Domain_Model_Organisation) {
				if ($organisationObj->getOrganisationtype() instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationType) {
					$organisationsObj[$organisation["organisation"]] = $organisationObj;
				}
			}
		}
		$this->view->assign("helfOMat", $helfOMat);
		$this->view->assign("organisationsObj", $organisationsObj);
		$this->view->assign("organisationPercent", $organisationPercent);
	}

	protected function calculateActivitiesAndNot($helfOMat, $answer, $persLat, $persLng, $age) {
		$activities = array(); // All "yes" activities
		$activitiesNot = array(); // All "no" activities
		$activityGroup = array();
		foreach ($helfOMat->getQuestions() as $question) {
			if (isset($answer[$question->getUid()]) && is_numeric($answer[$question->getUid()])
				&& $answer[$question->getUid()] >= 1 && $answer[$question->getUid()] <= 2) {
				if ($answer[$question->getUid()] == 1) { // Yes
					$activitiesNew = $this->getObjectStorageUids($question->getPositive());
					$activitiesNotNew = $this->getObjectStorageUids($question->getNegative());
				} else { // No
					$activitiesNew = $this->getObjectStorageUids($question->getPositivenot());
					$activitiesNotNew = $this->getObjectStorageUids($question->getNegativenot());
				}

				$activities = array_merge($activities, $activitiesNew);
				$activitiesNot = array_merge($activitiesNot, $activitiesNotNew);

				foreach ($activitiesNew as $activitiesNewId) {
					if (!isset($activityGroup[$activitiesNewId])) {
						$activityGroup[$activitiesNewId] = $question->getUid();
					} else if (in_array($activitiesNewId, $activitiesNot)) {
						$remove = array_search($activitiesNewId, $activitiesNot);
						unset($activitiesNot[$remove]);
					}
				}

				foreach ($activitiesNotNew as $activitiesNotNewId) {
					if (!isset($activityGroup[$activitiesNotNewId])) {
						$activityGroup[$activitiesNotNewId] = $question->getUid();
					} else if (in_array($activitiesNotNewId, $activities)) {
						$remove = array_search($activitiesNotNewId, $activities);
						unset($activities[$remove]);
					}
				}
			}
		}
		return array(array_unique($activities), array_unique($activitiesNot), $activityGroup);
	}

	private function getObjectStorageUids($storage) {
		$uids = array();
		foreach ($storage as $entry) {
			$uids[] = $entry->getUid();
		}
		return $uids;
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_HelfOMatQuestion $question
	 */
	public function masterAction(Tx_HelfenKannJeder_Domain_Model_HelfOMatQuestion $question = null) {
		$persLat = 49.009227;
		$persLng = 8.403929;
		$age = 18;

		$helfOMatList = $this->helfOMatRepository->findAll();
		$this->view->assign("helfOMatList", $helfOMatList);

		if ($question != null) {
			$helfOMat = $question->getHelfomat();
			$answer = array($question->getUid() => 1);
			$this->view->assign("question", $question);

			$organisationsVoting = $this->calculateVoting($helfOMat, $answer, $persLat, $persLng, $age);
			$this->view->assign("organisationsVotingPositive", $organisationsVoting);

			$answer = array($question->getUid() => 2);
			$organisationsVotingNegative = $this->calculateVoting($helfOMat, $answer, $persLat, $persLng, $age);
			$this->view->assign("organisationsVotingNegative", $organisationsVotingNegative);
		}
	}

	protected function calculateVoting($helfOMat, $answer, $persLat, $persLng, $age) {
		list($activities, $activitiesNot, $activityGroup) = $this->calculateActivitiesAndNot($helfOMat, $answer, $persLat, $persLng, $age);
		list($organisationsNear, $matrices) = $this->groupRepository->findOrganisationMatricesNearLatLng($persLat, $persLng, $age);
		$organisationsVoting = $this->matrixFieldRepository->findByMatrixFieldAndMatrix(array_merge($activities, $activitiesNot), array(), array_keys($organisationsNear), $matrices, $activitiesNot, $activityGroup);
		return $organisationsVoting;
	}


}
?>
