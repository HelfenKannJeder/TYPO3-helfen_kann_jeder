<?php
class Tx_HelfenKannJeder_Domain_Repository_SupporterRepository
	extends Tx_Extbase_Domain_Repository_FrontendUserRepository {
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
