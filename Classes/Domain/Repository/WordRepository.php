<?php
class Tx_HelfenKannJeder_Domain_Repository_WordRepository
	extends Tx_Extbase_Persistence_Repository {
	public function clearDb() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(true);
		$query->statement("TRUNCATE TABLE tx_helfenkannjeder_domain_model_word")->execute();
		return true;
	}
}
?>
