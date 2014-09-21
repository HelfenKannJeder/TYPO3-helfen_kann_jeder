<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class SupporterRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository {
	function findByUsergroups($groups) {
		$query = $this->createQuery();
		$constraint = array();
		foreach ($groups as $group) {
			$constraint[] = $query->contains('usergroup', $group);
		}
		$query->matching($query->logicalAnd($constraint));
		return $query->execute(); 
	}
}
?>
