<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class UserdoActivitysearchRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findNotFoundedActivities() {
		$query = $this->createQuery();
		return $query->matching(
				$query->equals('result',0)
			)
				->setOrderings( array('input' => \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
