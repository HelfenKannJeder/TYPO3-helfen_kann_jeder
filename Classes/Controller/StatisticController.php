<?php
class Tx_HelfenKannJeder_Controller_StatisticController extends Tx_Extbase_MVC_Controller_ActionController {
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
		$this->pageId = intval(t3lib_div::_GP('id'));
		$this->userdoActivitysearchRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_UserdoActivitysearchRepository');
	}

	public function indexAction() {
		$this->view->assign('users', $this->userdoActivitysearchRepository->findNotFoundedActivities());
	}
}
?>
