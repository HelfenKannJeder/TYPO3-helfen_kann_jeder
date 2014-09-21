<?php
namespace Querformatik\HelfenKannJeder\Controller;

class MapController
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	protected $organisationRepository;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');
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
