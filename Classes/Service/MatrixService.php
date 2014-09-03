<?php
class Tx_HelfenKannJeder_Service_MatrixService implements t3lib_Singleton {
	private $activityList;
	private $matrix;

	public function __construct() {
	}

	public function getActivityList() {
		return $this->activityList;
	}

	public function getMatrix() {
		return $this->matrix;
	}

	public function buildOrganisationMatrix( $organisation) {
		$matrixA = array();
		$activityList = array();
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_Organisation
			|| $organisation instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft) {
			foreach ($organisation->getGroups() as $group) {
				$matrix = $group->getMatrix();
				if ($matrix instanceof Tx_HelfenKannJeder_Domain_Model_Matrix) {
					foreach ($matrix->getMatrixfields() as $matrixfield) {
						if ($matrixfield > 0) {
							if ($matrixfield->getActivityfield() instanceof Tx_HelfenKannJeder_Domain_Model_Activityfield &&
								$matrixfield->getActivity() instanceof Tx_HelfenKannJeder_Domain_Model_Activity) {
								$activityfield = $matrixfield->getActivityfield()->getUid();
								$activity = $matrixfield->getActivity()->getUid();
								if (!isset($matrixA[$activityfield])) {
									$matrixA[$activityfield] = array();
								}
								if (!isset($matrixA[$activityfield][$activity]) || $matrixA[$activityfield][$activity] < $matrixfield) {
									$matrixA[$activityfield][$activity] = $matrixfield;
								}
								$activityList[] = $activity;
							}
						}
					}
				} else {
				}
			}
		}
		$this->matrix = $matrixA;
		$this->activityList = $activityList;
	}
}
?>
