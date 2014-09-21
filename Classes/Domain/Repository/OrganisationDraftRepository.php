<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class OrganisationDraftRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	public function findBySupporterAndRequest(\Querformatik\HelfenKannJeder\Domain\Model\Supporter $supporter) {
		$query = $this->createQuery();
		return $query->matching(
				$query->equals('supporter', $supporter)
			)
			->setOrderings(array('request' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING, 'requesttime' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING))
			->execute();
	}

	public function findUncompeletedRegistrations($lastRemind=-14) {
	        $query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('request',0),
				$query->equals('reference',0),
				$query->logicalOr(
					$query->logicalAnd(
						$query->lessThan('remind_last',time()+($lastRemind*86400)),
						$query->equals('remind_count',0)
					),
					$query->logicalAnd(
						$query->lessThan('remind_last',time()+($lastRemind*2*86400)),
						$query->equals('remind_count',1)
					),
					$query->logicalAnd(
						$query->lessThan('remind_last',time()+($lastRemind*4*86400)),
						$query->equals('remind_count',2)
					)
				),
				$query->lessThan('crdate',time()+($lastRemind*86400))
			)
		)->execute();
	}
}
?>
