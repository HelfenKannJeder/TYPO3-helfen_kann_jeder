<?php
class Tx_HelfenKannJeder_Domain_Repository_RegisterOrganisationProgressRepository
	extends Tx_Extbase_Persistence_Repository {
	public function findByCurrentSession($sessionId, $lifetime) {
	        $query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('sessionid',$sessionId),
				$query->greaterThanOrEqual('modified',time()-$lifetime)
			)
		)
				->setLimit(1)
				->execute()->getFirst();
	}
}
?>
