<?php
/**
 * Remind controller
 */
class Tx_HelfenKannJeder_Command_OrganisationCommandController extends Tx_Extbase_MVC_Controller_CommandController {

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Repository_GroupRepository
	 * @inject
	 */
	protected $groupRepository;

	public function refreshHelfOMatCacheCommand() {
		$this->groupRepository->generateQuestionOrganisationMappingCache();
	}
}
?>
