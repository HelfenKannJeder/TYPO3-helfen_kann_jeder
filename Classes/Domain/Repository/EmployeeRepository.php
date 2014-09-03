<?php
class Tx_HelfenKannJeder_Domain_Repository_EmployeeRepository
	extends Tx_Extbase_Persistence_Repository {
	public function findByOrganisationUid($organisationUid) {
	        $query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation',$organisationUid))
				->setOrderings( array('prename' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING) )
				->execute();
	}

	public function findByOrganisationUidWithStatement($organisationUid) {
	        $query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('organisation',$organisationUid),
				$query->logicalOr(
					$query->logicalNot($query->equals('teaser', '')),
					$query->logicalNot($query->equals('motivation', ''))
				),
				$query->logicalNot($query->equals('uid', 28))
			)
		)
				->setOrderings( array('prename' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
