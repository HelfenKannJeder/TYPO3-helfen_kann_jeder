<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class WordRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	public function clearDb() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(true);
		$query->statement("TRUNCATE TABLE tx_helfenkannjeder_domain_model_word")->execute();
		return true;
	}
}
?>
