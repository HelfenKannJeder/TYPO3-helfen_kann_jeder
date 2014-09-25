<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class GroupRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findNearLatLng($lat, $lng, $age=18) {
		$query = $this->createQuery();
		$statement = "
			SELECT
				t0.uid,
				t0.pid,
				t0.organisation,
				t0.name,
				t0.description,
				t0.minimum_age,
				t0.maximum_age,
				t0.tstamp,
				t0.crdate,
				t0.deleted,
				t0.hidden,
				t0.sys_language_uid,
				t0.l18n_parent,
				t0.l18n_diffsource,
				t0.access_group,
				t0.matrix,
				t1.longitude,
				t1.latitude,
				t0.website,
				t0.workinghours,
				t0.sort,
				t0.contactpersons,
				t1.is_dummy,
				t1.organisationtype
			FROM
				tx_helfenkannjeder_domain_model_organisation AS t1
			LEFT JOIN
				tx_helfenkannjeder_domain_model_group AS t0
					ON
				t0.organisation = t1.uid
			LEFT JOIN
				tx_helfenkannjeder_domain_model_organisationtype AS t2
					ON
				t1.organisationtype = t2.uid
			WHERE
				(
				t1.latitude >= ".($lat-1.5)." AND
				t1.latitude <= ".($lat+1.5)." AND
				t1.longitude >= ".($lng-1.5)." AND
				t1.longitude <= ".($lng+1.5)." AND
				t0.minimum_age <= ".(int)$age." AND
				t0.maximum_age >= ".(int)$age." AND
				t2.hide_in_result = 0
				) OR t1.is_dummy = 1
				";
		//file_put_contents("test.txt", $statement);
		$query->statement($statement , array( ));
		return $query;
	}

	public function findNearLatLngExecute($lat, $lng, $age=18) {
		$query = $this->findNearLatLng($lat, $lng, $age);
		return $query->execute();
	}

	public function findGroupMatricesNearLatLng($lat, $lng, $age=18) {
		$query = $this->findNearLatLng($lat, $lng, $age);
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$groups = $query->execute();

		$matrices = array();
		foreach ($groups as $group) {
			if (!isset($matrices[$group["matrix"]])) {
				$matrices[$group["matrix"]] = array();
			}
			$matrices[$group["matrix"]][] = array($group["organisation"], $group["latitude"], $group["longitude"]);
		}
		return $matrices;
	}

	public function findOrganisationMatricesNearLatLng($lat, $lng, $age=18) {
		$query = $this->findNearLatLng($lat, $lng, $age);
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$groups = $query->execute();

		$organisations = array();
		$matrices = array();
		foreach ($groups as $group) {
			if (!isset($organisations[$group["organisation"]])) {
				$organisations[$group["organisation"]] =  array(
					0 => $group["latitude"],
					1 => $group["longitude"],
					'organisation' => $group['organisation'],
					'gradesum' => 100,
					'is_dummy' => $group['is_dummy'],
					'organisationtype' => $group['organisationtype']
				);
			}
			$matrices[] = $group["matrix"];
		}
		return array($organisations, array_unique($matrices));
	}

	public function findByOrganisationUid($organisationUid) {
	        $query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation',$organisationUid))
				->setOrderings( array('sort' => \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
				->execute();
	}

	public function findByGroupMappingWithAnswersAndOrganisation($questionYes, $questionNo, $organisations) {
		if (!is_array($questionYes)) $questionYes = array();
		$questionYes[] = -1;
		if (!is_array($questionNo)) $questionNo = array();
		$questionNo[] = -1;
		if (!is_array($organisations)) $organisations = array();
		if ($organisations == array('')) {
			$organisations = array();
		}

		$organisations[] = -1;

		$statement = "
			SELECT
				SUM(
					IF ((questionUid IN (".implode(',', $questionYes).")), yes, 0) +
					IF ((questionUid IN (".implode(',', $questionNo).")), no, 0)
				)*100/(".(count($questionYes)+count($questionNo)-2).") AS gradesum,
				organisationUid AS organisation
			FROM `tx_helfenkannjeder_helfomat_question_organisation_mapping_cache`
			WHERE organisationUid IN(".implode(',', $organisations).")
			GROUP BY organisationUid
			ORDER BY gradesum DESC";
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement($statement , array( ));
		return $query->execute();
	}

	public function generateQuestionOrganisationMappingCache() {
		$GLOBALS['TYPO3_DB']->sql_query("TRUNCATE TABLE tx_helfenkannjeder_helfomat_question_organisation_mapping_cache");
		$GLOBALS['TYPO3_DB']->sql_query("INSERT INTO tx_helfenkannjeder_helfomat_question_organisation_mapping_cache (SELECT * FROM tx_helfenkannjeder_helfomat_question_organisation_mapping)");
	}
}
?>
