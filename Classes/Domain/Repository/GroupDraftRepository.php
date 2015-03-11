<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

/**
 * This class represents a group draft, part of an organisation in draft mode.
 *
 * @author Valentin Zickner
 */
class GroupDraftRepository extends GroupRepository {

	// TODO: This method seems to be similar to EmployeeDraftRepository.
	public function findByOrganisationAndTemplate($organisation, $template) {
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$organisationUid = $organisation->getUid();
		} elseif (is_int($organisation)) {
			$organisationUid = $organisation;
		} else {
			return FALSE;
		}

		if ($template instanceof \Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate) {
			$templateUid = $template->getUid();
		} elseif (is_int($template)) {
			$templateUid = $template;
		} else {
			return FALSE;
		}

		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('organisation', $organisationUid),
				$query->equals('template', $templateUid)
			))
			->setOrderings( array('sort' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}

	public function findByOrganisationGroupListByTemplate($organisation) {
		$groupListByTemplate = array();
		if ($organisation != NULL) {
			$groupList = $this->findByOrganisation($organisation);
			foreach ($groupList as $group) {
				if ($group->getTemplate() instanceof \Querformatik\HelfenKannJeder\Domain\Model\GroupTemplate) {
					$groupListByTemplate[$group->getTemplate()->getUid()] = $group;
				}
			}
		}
		return $groupListByTemplate;
	}

	// TODO: This method seems to be similar to EmployeeDraftRepository.
	public function findByOrganisationUid($organisationUid) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('organisation', $organisationUid))
			->setOrderings( array('sort' =>  \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_ASCENDING) )
			->execute();
	}
}
