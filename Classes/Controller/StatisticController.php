<?php
namespace Querformatik\HelfenKannJeder\Controller;

class StatisticController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	/**
	 * @var integer
	 */
	protected $pageId;

	private $userDoActivitysearchRepository;

	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->pageId = intval(\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id'));
		$this->userdoActivitysearchRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\UserdoActivitysearchRepository');
	}

	public function indexAction() {
		$this->view->assign('users', $this->userdoActivitysearchRepository->findNotFoundedActivities());
	}
}
?>
