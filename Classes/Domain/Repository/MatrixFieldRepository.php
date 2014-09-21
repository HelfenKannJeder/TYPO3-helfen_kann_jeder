<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class MatrixFieldRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {


	/**
	 */
	public function findByMatrixFieldAndMatrix($activities, $activityfields, $organisations, $matrices, $activitiesNot = array(), $activityMapperArray = array(), $detail=false) {
		if (!is_array($matrices)) {
			$matrices = array();
		}
		$matrices[] = 0;

		$query = $this->createQuery();

		if (!is_array($organisations) || count($organisations) == 0) {
			$organisations = array();
		}

		if (!is_array($activities) || count($activities) == 0) {
			$activities = array();
		}

		if (!is_array($activitiesNot) || count($activitiesNot) == 0) {
			$activitiesNot = array();
		}
		$activitiesNot[] = -1;

		$fromLine = "tx_helfenkannjeder_domain_model_matrixfield AS t0 ";
		$maxsum = 1;

		if ((!is_array($activityfields) || count($activityfields) == 0) &&
			(!is_array($activities) || count($activities) == 0)) {
			$fromLine .= "WHERE 1 <> 1";
		} else if (!is_array($activityfields) || count($activityfields) == 0) {
			$queryCount = $this->createQuery();
			$queryCount->statement("SELECT uid_foreign, COUNT( uid ) AS count
				FROM tx_helfenkannjeder_activityfield_activity_mm
				WHERE uid_foreign IN(".implode(",", $activities).")
				GROUP BY uid_foreign" , array( ));
			$queryCount->getQuerySettings()->setReturnRawQueryResult(TRUE);
			$countInfo = $queryCount->execute();

			$completed = "CASE ";
			foreach ($countInfo as $countInfoSingle) {
				$completed .= "WHEN t1.activity=".$countInfoSingle["uid_foreign"]." THEN ".$countInfoSingle["count"]." ";
			}
			$completed .= "END";

			$activityMapper = "activity";
			$maxsum = count($activities);

			if (is_array($activityMapperArray) && count($activityMapperArray) > 0) {
				$maxsum = count(array_unique($activityMapperArray));
				$activityMapper = "CASE ";
				foreach ($activityMapperArray as $activityMapperId => $activityMapperGroup) {
					$activityMapper .= " WHEN activity=".$activityMapperId." THEN ".$activityMapperGroup;
				}
				$activityMapper .= " ELSE 0";
				$activityMapper .= " END AS activity";
			}


			// 8 = Organisationsintern, 18 = Jugendarbeit
			$fromLine = "
				(
					SELECT
						t2.organisation,
						t2.matrix,
						t1.activity,
						CASE
						WHEN (t1.activity IN(".implode(",", $activitiesNot).")) THEN
							MIN(CASE
								WHEN (t1.activityfield IN(8,18) AND t1.activity NOT IN (36, 59)) THEN
									CASE    WHEN t1.grade=1 THEN    100
										WHEN t1.grade=2 THEN    80
										ELSE                    100
									END
								ELSE
									CASE    WHEN t1.grade=1 THEN    100
										WHEN t1.grade=2 THEN    0
										ELSE                    100
									END
								END)
						ELSE
							MAX(CASE
								WHEN (t1.activityfield IN(8,18) AND t1.activity NOT IN (36, 59)) THEN
									CASE 	WHEN t1.grade=1	THEN    4
										WHEN t1.grade=2	THEN    20
				                                                ELSE			0
									END
								ELSE
									CASE 	WHEN t1.grade=1	THEN    20
										WHEN t1.grade=2	THEN    100
				                                                ELSE			0
									END
								END)
						END AS grade,
						CASE	WHEN (t1.activity IN(".implode(",", $activitiesNot).")) THEN 0 "./* # einfach gewichtet negativ*/"
							WHEN (t1.activity IN(-1)) THEN 2 "./*# doppelt gewichtet (positiv)*/"
							ELSE 1 END AS posit,
						CASE	WHEN (t1.activity IN(-1)) THEN 2 "./*# doppelt gewichtet negativ*/"
							WHEN (t1.activity IN(".implode(",", $activitiesNot).")) THEN 1 "./*# (einfach gewichtet) negativ*/"
							ELSE 0 END AS negat
					FROM
						tx_helfenkannjeder_domain_model_group AS t2
					LEFT JOIN
						tx_helfenkannjeder_domain_model_matrixfield AS t1
							ON
						t2.matrix = t1.matrix AND t1.deleted = 0
					WHERE
                                        	t1.activity IN(".implode(",", $activities).") AND t2.deleted = 0 AND t2.matrix IN(".implode(",",$matrices).")
						AND t2.organisation IN(".implode(",", $organisations).")
					GROUP BY
						t2.organisation, t1.activity) AS t3"; // TODO prove by organisations
			$fromLine = "
					SELECT
						organisation.uid AS organisation,
						organisation.name,
						SUM(t100.grade),
						COUNT(t100.grade),
						SUM(t100.posit),
						SUM(t100.negat),
						(SUM(COALESCE(t100.grade,0))+(".(count($activitiesNot)-1)."-SUM(COALESCE(t100.negat,0)))*100)/".(count($activities))." AS gradesum
					FROM
					(
						SELECT
							organisation,
							".$activityMapper.",
							SUM(grade) AS grade,
							MAX(grade) AS maxGrade,
							MIN(grade) AS minGrade,
							SUM(posit) AS posit,
							SUM(negat) AS negat
						FROM ( ".$fromLine.")
						GROUP BY organisation, activity
					) AS t100
					RIGHT JOIN
						tx_helfenkannjeder_domain_model_organisation AS organisation
							ON
						t100.organisation = organisation.uid AND organisation.deleted = 0 AND organisation.uid IN(".implode(",", $organisations).")
					WHERE
						organisation.deleted = 0 AND organisation.uid IN(".implode(",", $organisations).")
					GROUP BY
						organisation.uid
					HAVING gradesum > 0
					ORDER BY
						gradesum DESC
					";

/*
			if (count($activitiesNot) > 0) {
				$activitiesNotMapped = array();
				foreach ($activitiesNot as $activitiesNotId) {
					$acitivitiesNotMapped[$activityMapperArray[$activitiesNotId]] = 1;
				}

				$statement = "
					SELECT
						t0.organisation,
						(SUM(
							CASE
								WHEN t0.grade>=50 THEN 100
								ELSE t0.grade
							END
						)+100*(".count($acitivitiesNotMapped)."-SUM(t0.negat)))/".$maxsum." AS gradesum
					FROM (".$fromLine.") AS t0
					GROUP BY t0.organisation
					ORDER BY gradesum DESC
				";
			} else {
				$statement = "
					SELECT
						t0.organisation,
						SUM(CASE WHEN t0.grade>=50 THEN 100
						ELSE t0.grade END)/".$maxsum." AS gradesum
					FROM (".$fromLine.") AS t0
					GROUP BY t0.organisation
					ORDER BY gradesum DESC
				";
			}*/

			//if ($detail) 
			$statement = $fromLine;
		} else if (!is_array($activities) || count($activities) == 0) {
			$fromLine = "
				(SELECT
					t1.matrix AS matrix,
					MAX(t1.grade) AS grade
				FROM
					tx_helfenkannjeder_domain_model_matrixfield AS t1
				WHERE
					activityfield IN(".implode(",", $activityfields).") AND t1.matrix IN(".implode(",",$matrices).")
				GROUP BY
					matrix, activityfield) AS t0 ";
			$maxsum = count($activityfields);
		} else {
                        $maxsum = count($activities);
                        $statement = "
                                SELECT
                                        t2.organisation,
                                        SUM(t2.maxi)/".$maxsum." AS gradesum
                                FROM
                                        (SELECT
                                                t1.organisation,
                                                MAX(CASE        WHEN t0.grade=1         THEN    20
                                                        WHEN t0.grade=2         THEN    100
                                                        ELSE                            0
                                                END) AS maxi

                                        FROM
                                                tx_helfenkannjeder_domain_model_group AS t1
                                        LEFT JOIN
                                                tx_helfenkannjeder_domain_model_matrixfield AS t0
                                                        ON
                                                t1.matrix = t0.matrix AND t0.deleted = 0
                                        WHERE t0.activity IN(".implode(",", $activities).") AND t1.deleted = 0 AND t0.activityfield IN(".implode(",", $activityfields).")
						AND t1.organisation IN(".implode(",", $organisations).")
					GROUP BY t1.organisation, t0.activity
                                        ) AS t2

                                GROUP BY t2.organisation
                                ORDER BY gradesum DESC
                        ";
		}

		if (!isset($statement)) {
			$statement = "
				SELECT
					t0.organisation,
					SUM(CASE WHEN t0.grade=1 	THEN	20
						WHEN t0.grade=2		THEN	100
						ELSE				0
						END)/".$maxsum." AS gradesum
				FROM ".$fromLine."
				GROUP BY t0.organisation
				ORDER BY gradesum DESC
			";
		}


		$query->statement($statement , array( ));
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		return $query->execute();

	}
}
?>
