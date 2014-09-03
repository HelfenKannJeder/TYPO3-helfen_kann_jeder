<?php
class Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository
	extends Tx_Extbase_Persistence_Repository {
	public function findByUids($uids) {
		$query = $this->createQuery();
		$constraints = array();

		$query->matching($query->in('uid', $uids));
		return $query->execute();
	}

	public function findNearLatLngCount ($lat, $lng, $age=18) {
		$query = $this->createQuery();
/*
		$query = $query->matching($query->logicalAnd(
			$query->greaterThanOrEqual('latitude', $lat-0.5),
			$query->lessThanOrEqual('latitude', $lat+0.5),
			$query->greaterThanOrEqual('longitude', $lng-0.5),
			$query->lessThanOrEqual('longitude', $lng+0.5)
		));
		$query = $query->setOrderings(array("latitude" => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));*/
		$statement = "
			SELECT
				COUNT(DISTINCT t1.uid) AS num
			FROM
				tx_helfenkannjeder_domain_model_organisation AS t1
			LEFT JOIN
				tx_helfenkannjeder_domain_model_group AS t0
					ON
				t0.organisation = t1.uid
			WHERE
				t1.latitude >= ".($lat-0.5)." AND
				t1.latitude <= ".($lat+0.5)." AND
				t1.longitude >= ".($lng-0.5)." AND
				t1.longitude <= ".($lng+0.5)." AND
				t0.minimum_age <= ".(int)$age." AND
				t0.maximum_age >= ".(int)$age." AND
				t1.deleted <> 1 AND
				t0.deleted <> 1
			ORDER BY
				(POW(((t1.latitude-".$lat.")*1.2), 2)+POW((t1.longitude-".$lng."), 2))
				";
		$query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		//file_put_contents("test.txt", $statement);
		$query->statement($statement , array( ));
		$result = $query->execute();
		return $result[0]["num"];
	}

	public function findNearLatLng($lat, $lng, $age=18) {
		$query = $this->createQuery();
/*
		$query = $query->matching($query->logicalAnd(
			$query->greaterThanOrEqual('latitude', $lat-0.5),
			$query->lessThanOrEqual('latitude', $lat+0.5),
			$query->greaterThanOrEqual('longitude', $lng-0.5),
			$query->lessThanOrEqual('longitude', $lng+0.5)
		));
		$query = $query->setOrderings(array("latitude" => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));*/
		$statement = "
			SELECT
				t1.*
			FROM
				tx_helfenkannjeder_domain_model_organisation AS t1
			LEFT JOIN
				tx_helfenkannjeder_domain_model_group AS t0
					ON
				t0.organisation = t1.uid
			WHERE
				t1.latitude >= ".($lat-0.5)." AND
				t1.latitude <= ".($lat+0.5)." AND
				t1.longitude >= ".($lng-0.5)." AND
				t1.longitude <= ".($lng+0.5)." AND
				t0.minimum_age <= ".(int)$age." AND
				t0.maximum_age >= ".(int)$age." AND
				t1.deleted <> 1 AND
				t0.deleted <> 1
			GROUP BY
				t1.uid
			ORDER BY
				(POW(((t1.latitude-".$lat.")*1.2), 2)+POW((t1.longitude-".$lng."), 2))
				";
		//file_put_contents("test.txt", $statement);
		$query->statement($statement , array( ));
		return $query;
	}

	public function findNearLatLngExecute($lat, $lng, $age=18) {
		$query = $this->findNearLatLng($lat, $lng, $age);
		return $query->execute();
	}

}
?>
