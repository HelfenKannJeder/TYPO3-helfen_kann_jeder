<?php
namespace Querformatik\HelfenKannJeder\Service;

class MatrixService implements \TYPO3\CMS\Core\SingletonInterface {
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
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation
			|| $organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft) {
			foreach ($organisation->getGroups() as $group) {
				$matrix = $group->getMatrix();
				if ($matrix instanceof \Querformatik\HelfenKannJeder\Domain\Model\Matrix) {
					foreach ($matrix->getMatrixfields() as $matrixfield) {
						if ($matrixfield > 0) {
							if ($matrixfield->getActivityfield() instanceof \Querformatik\HelfenKannJeder\Domain\Model\Activityfield &&
								$matrixfield->getActivity() instanceof \Querformatik\HelfenKannJeder\Domain\Model\Activity) {
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
