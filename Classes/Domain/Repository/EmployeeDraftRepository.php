<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

/**
 * Representing the draft of an employee
 *
 * @author Valentin Zickner
 */
class EmployeeDraftRepository extends EmployeeRepository {

	// TODO: This is maybe a duplicate of parent method.
	public function findByOrganisationAndUid($organisation, $uid) {
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$organisationUid = $organisation->getUid();
		} elseif (is_int($organisation)) {
			$organisationUid = $organisation;
		} else {
			return FALSE;
		}

		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('organisation', $organisationUid),
				$query->equals('uid', $uid)
			))
			->setLimit(1)
			->execute();
	}


	// TODO: This is maybe a duplicate of parent method.
	public function findByOrganisationUidWithStatement($organisationUid) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('organisation', $organisationUid),
					$query->logicalNot($query->equals('motivation', ''))
				)
			)
			->setOrderings( array('prename' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}
}
