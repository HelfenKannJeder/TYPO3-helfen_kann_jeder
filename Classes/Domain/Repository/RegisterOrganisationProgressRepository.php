<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class RegisterOrganisationProgressRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
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
