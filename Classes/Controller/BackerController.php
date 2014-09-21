<?php
namespace Querformatik\HelfenKannJeder\Controller;

class BackerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	protected $backerRepository;

	public function initializeAction() {
		$this->backerRepository = $this->objectManager->get('\Querformatik\HelfenKannJeder\Domain\Repository\BackerRepository');
		$this->backerRepository->setDefaultOrderings(array('since'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\Backer $backer The backer to display
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
