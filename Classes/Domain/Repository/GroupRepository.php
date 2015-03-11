<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

/**
 * This class represents informations about group repositories. It also queries
 * the corresponding groups for Helf-O-Mat searches.
 *
 * @author Valentin Zickner
 */
class GroupRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findByOrganisationUid($organisationUid) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation', $organisationUid))
				->setOrderings( array('sort' => \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
				->execute();
	}

	public function findByGroupMappingWithAnswersAndOrganisation($questionYes, $questionNo, $organisations) {
		if (!is_array($questionYes)) {
			$questionYes = array();
		}
		$questionYes[] = -1;
		if (!is_array($questionNo)) {
			$questionNo = array();
		}
		$questionNo[] = -1;
		if (!is_array($organisations)) {
			$organisations = array();
		}
		if ($organisations == array('')) {
			$organisations = array();
		}

		$organisations[] = -1;

		$statement = '
			SELECT
				SUM(
					IF ((questionUid IN (' . implode(',', $questionYes) . ')), yes, 0) +
					IF ((questionUid IN (' . implode(',', $questionNo) . ')), no, 0)
				)*100/(' . (count($questionYes) + count($questionNo) - 2) . ') AS gradesum,
				organisationUid AS organisation
			FROM `tx_helfenkannjeder_helfomat_question_organisation_mapping_cache`
			WHERE organisationUid IN(' . implode(',', $organisations) . ')
			GROUP BY organisationUid
			ORDER BY gradesum DESC';
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement($statement, array( ));
		return $query->execute();
	}

	public function generateQuestionOrganisationMappingCache() {
		$GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE tx_helfenkannjeder_helfomat_question_organisation_mapping_cache');
		$GLOBALS['TYPO3_DB']->sql_query('INSERT INTO tx_helfenkannjeder_helfomat_question_organisation_mapping_cache
			(SELECT * FROM tx_helfenkannjeder_helfomat_question_organisation_mapping)');
	}
}
