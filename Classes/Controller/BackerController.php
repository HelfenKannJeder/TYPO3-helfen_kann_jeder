<?php
class Tx_HelfenKannJeder_Controller_BackerController
	extends Tx_Extbase_MVC_Controller_ActionController {

	protected $backerRepository;

	public function initializeAction() {
		$this->backerRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_BackerRepository');
		$this->backerRepository->setDefaultOrderings(array('since'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Backer $backer The backer to display
	 * @return void
	 */
	public function indexAction($backer = null) {
		if ($backer == null) {
			$backer = $this->backerRepository->findByUid(1);
		}

		$backers = $this->backerRepository->findAll();
		$backersIdeal = array();
		$backersFinancial = array();
		foreach ($backers as $backerOne) {
			if ($backerOne->getType() == 1) {
				$backersIdeal[] = $backerOne;
			} else {
				$backersFinancial[] = $backerOne;
			}
		}

		$this->view->assign('backerSelected', $backer);
		$this->view->assign('backersLength', 125*count($backers));
		$this->view->assign('backers', $backers);
		$this->view->assign('backersIdeal', $backersIdeal);
		$this->view->assign('backersFinancial', $backersFinancial);
	}
}
?>
