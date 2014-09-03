<?php
class Tx_HelfenKannJeder_Domain_Repository_EmployeeDraftRepository
	extends Tx_HelfenKannJeder_Domain_Repository_EmployeeRepository {

	public function findByOrganisationAndUid($organisation, $uid) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_Organisation) {
			$organisationUid = $organisation->getUid();
		} else if (is_int($organisation)) {
			$organisationUid = $organisation;
		} else {
			return false;
		}

	        $query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('organisation',$organisationUid),
					$query->equals('uid',$uid)
				))
				->setLimit(1)
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
				)
			)
		)
				->setOrderings( array('prename' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
