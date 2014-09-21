<?php
namespace Querformatik\HelfenKannJeder\Command;

/**
 * Remind controller
 */
class OrganisationCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\GroupRepository
	 * @inject
	 */
	protected $groupRepository;

	public function refreshHelfOMatCacheCommand() {
		$this->groupRepository->generateQuestionOrganisationMappingCache();
	}
}
?>
