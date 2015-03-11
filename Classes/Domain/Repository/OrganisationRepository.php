<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

/**
 * Find and modify organisations
 *
 * @author Valentin Zickner
 */
class OrganisationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findNearLatLngCount($lat, $lng, $age = 18) {
		$query = $this->createQuery();
		$statement = '
			SELECT
				COUNT(DISTINCT t1.uid) AS num
			FROM
				tx_helfenkannjeder_domain_model_organisation AS t1
			LEFT JOIN
				tx_helfenkannjeder_domain_model_group AS t0
					ON
				t0.organisation = t1.uid
			WHERE
				t1.latitude >= ' . ($lat - 0.5) . ' AND
				t1.latitude <= ' . ($lat + 0.5) . ' AND
				t1.longitude >= ' . ($lng - 0.5) . ' AND
				t1.longitude <= ' . ($lng + 0.5) . ' AND
				t0.minimum_age <= ' . (int)$age . ' AND
				t0.maximum_age >= ' . (int)$age . ' AND
				t1.deleted <> 1 AND
				t0.deleted <> 1
			ORDER BY
				(POW(((t1.latitude-' . $lat . ')*1.2), 2)+POW((t1.longitude-' . $lng . '), 2))
				';
		$query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$query->statement($statement, array());
		$result = $query->execute();
		return $result[0]['num'];
	}

	public function findNearLatLng($lat, $lng, $age = 18) {
		$query = $this->createQuery();
		$statement = '
			SELECT
				t1.*
			FROM
				tx_helfenkannjeder_domain_model_organisation AS t1
			LEFT JOIN
				tx_helfenkannjeder_domain_model_group AS t0
					ON
				t0.organisation = t1.uid
			WHERE
				t1.latitude >= ' . ($lat - 0.5) . ' AND
				t1.latitude <= ' . ($lat + 0.5) . ' AND
				t1.longitude >= ' . ($lng - 0.5) . ' AND
				t1.longitude <= ' . ($lng + 0.5) . ' AND
				t0.minimum_age <= ' . (int)$age . ' AND
				t0.maximum_age >= ' . (int)$age . ' AND
				t1.deleted <> 1 AND
				t0.deleted <> 1
			GROUP BY
				t1.uid
			ORDER BY
				(POW(((t1.latitude-' . $lat . ')*1.2), 2)+POW((t1.longitude-' . $lng . '), 2))
				';
		$query->statement($statement, array());
		return $query;
	}

	public function findNearLatLngExecute($lat, $lng, $age = 18) {
		$query = $this->findNearLatLng($lat, $lng, $age);
		return $query->execute();
	}

}
