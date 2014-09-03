<?php
class Tx_HelfenKannJeder_Domain_Repository_UserdoActivitysearchRepository
	extends Tx_Extbase_Persistence_Repository {

	public function findNotFoundedActivities() {
		$query = $this->createQuery();
		return $query->matching(
				$query->equals('result',0)
			)
				->setOrderings( array('input' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
