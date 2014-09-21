<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

class GroupDraftRepository extends GroupRepository {
	public function findByOrganisationAndTemplate($organisation, $template) {
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$organisationUid = $organisation->getUid();
		} else if (is_int($organisation)) {
			$organisationUid = $organisation;
		} else {
			return false;
		}

		if ($template instanceof \Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate) {
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
				->setOrderings( array('sort' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
				->execute();
	}

	public function findByOrganisationGroupListByTemplate($organisation) {
		$groupListByTemplate = array();
		if ($organisation != null) {
			$groupList = $this->findByOrganisation($organisation);
			foreach ($groupList as $group) {
				if ($group->getTemplate() instanceof \Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate) {
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
				->setOrderings( array('sort' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
				->execute();
	}
}
?>
