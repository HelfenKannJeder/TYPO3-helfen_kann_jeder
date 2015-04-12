<?php
/*
 * Copyright (C) 2015 Valentin Zickner <valentin.zickner@helfenkannjeder.de>
 *
 * This file is part of HelfenKannJeder.
 *
 * HelfenKannJeder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HelfenKannJeder is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HelfenKannJeder.  If not, see <http://www.gnu.org/licenses/>.
 */
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
