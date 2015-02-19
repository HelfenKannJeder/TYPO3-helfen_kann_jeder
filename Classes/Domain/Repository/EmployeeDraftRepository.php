<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class EmployeeDraftRepository extends EmployeeRepository {

	public function findByOrganisationAndUid($organisation, $uid) {
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
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
				$query->logicalNot($query->equals('motivation', ''))
			)
		)
				->setOrderings( array('prename' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
