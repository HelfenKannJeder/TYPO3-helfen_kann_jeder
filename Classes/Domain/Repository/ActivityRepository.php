<?php
class Tx_HelfenKannJeder_Domain_Repository_ActivityRepository
	extends Tx_Extbase_Persistence_Repository {
	public function findByMatchingSearchParameter($word) {

		$query = $this->createQuery();

		$word = strtolower($word);
		$searchAndReplace1 = array('ä', 'ö', 'ü', 'ß');
		$searchAndReplace2 = array('ae','oe','ue','ss');
		$word2 = str_replace($searchAndReplace1, $searchAndReplace2, $word);
		$word1 = str_replace($searchAndReplace2, $searchAndReplace1, $word);

		$statement = "
			SELECT
				COUNT(t0.uid) AS vote,
                                t0.word,
                                t1.uid,
                                t1.name,
				t1.description
			FROM
				tx_helfenkannjeder_domain_model_word AS t0
                        LEFT JOIN
                                tx_helfenkannjeder_domain_model_activity AS t1
                                        ON
                                t0.activity = t1.uid
			WHERE
				t0.word LIKE '% ".   $GLOBALS['TYPO3_DB']->quoteStr($word1)."%'
				OR t0.word LIKE '".  $GLOBALS['TYPO3_DB']->quoteStr($word1)."%'
				OR t0.word LIKE '%(".$GLOBALS['TYPO3_DB']->quoteStr($word1)."%'
				OR t0.word LIKE '% ".$GLOBALS['TYPO3_DB']->quoteStr($word2)."%'
				OR t0.word LIKE '".  $GLOBALS['TYPO3_DB']->quoteStr($word2)."%'
				OR t0.word LIKE '%(".$GLOBALS['TYPO3_DB']->quoteStr($word2)."%'
			GROUP BY
				t1.uid, t1.name
			ORDER BY
				vote DESC
			";

		$query->statement($statement , array( ));
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		return $query->execute();

	}
}
?>
