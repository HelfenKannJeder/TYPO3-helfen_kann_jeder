<?php
class Tx_HelfenKannJeder_Domain_Repository_GroupDraftRepository
	extends Tx_HelfenKannJeder_Domain_Repository_GroupRepository {
	public function findByOrganisationAndTemplate($organisation, $template) {
		if ($organisation instanceof Tx_HelfenKannJeder_Domain_Model_Organisation) {
			$organisationUid = $organisation->getUid();
		} else if (is_int($organisation)) {
			$organisationUid = $organisation;
		} else {
			return false;
		}

		if ($template instanceof Tx_HelfenKannJeder_Domain_Model_GroupTemplate) {
			$templateUid = $template->getUid();
		} else if (is_int($template)) {
			$templateUid = $template;
		} else {
			return false;
		}

	        $query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('organisation',$organisationUid),
					$query->equals('template',$templateUid)
				))
				->setOrderings( array('sort' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING) )
				->execute();
	}

	public function findByOrganisationGroupListByTemplate($organisation) {
		$groupListByTemplate = array();
		if ($organisation != null) {
			$groupList = $this->findByOrganisation($organisation);
			foreach ($groupList as $group) {
				if ($group->getTemplate() instanceof Tx_HelfenKannJeder_Domain_Model_GroupTemplate) {
					$groupListByTemplate[$group->getTemplate()->getUid()] = $group;
				}
			}
		}
		return $groupListByTemplate;
	}

	public function findByOrganisationUid($organisationUid) {
	        $query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation',$organisationUid))
				->setOrderings( array('sort' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
