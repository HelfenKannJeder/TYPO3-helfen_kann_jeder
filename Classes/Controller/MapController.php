<?php
class Tx_HelfenKannJeder_Controller_MapController
	extends Tx_Extbase_MVC_Controller_ActionController {
	protected $organisationRepository;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository');
	}

	/**
	 * @return void
	 */
	public function indexAction() { // TODO: Optimize performance
		$organisations =  $this->organisationRepository->findByIsDummy(0);
		$this->view->assign('organisations', $organisations);
	}

	public function kmlAction() {
	}
}

?>
