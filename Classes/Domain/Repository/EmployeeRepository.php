<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class EmployeeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	public function findByOrganisationUid($organisationUid) {
	        $query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation',$organisationUid))
				->setOrderings( array('prename' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
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
				->setOrderings( array('prename' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
