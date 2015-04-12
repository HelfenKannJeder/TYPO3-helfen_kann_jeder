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

class MatrixController
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	protected $accessControlService;
	protected $matrixService;
	protected $matrixRepository;
	protected $activityRepository;
	protected $activityfieldRepository;
	protected $excelService;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * injectPersistenceManager
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager
	 */
	public function injectPersistenceManager(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService');
		$this->matrixService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\MatrixService');

		$this->matrixRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\MatrixRepository');

		$this->activityRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\ActivityRepository');
		$this->activityRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));

		$this->activityfieldRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\ActivityFieldRepository');
		$this->activityfieldRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation The matrix to edit
	 * @return void
	 */
	public function viewAction(\Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation) {
		$activities = $this->activityRepository->findAll();
		$activityfields = $this->activityfieldRepository->findAll();
		$this->view->assign('activityfields', $activityfields);
		$this->view->assign('organisation', $organisation);

		$this->matrixService->buildOrganisationMatrix($organisation);
		$matrixA = $this->matrixService->getMatrix();
		$activityList = $this->matrixService->getActivityList();

		$activityList = array_unique($activityList);

		$activities = $activities->toArray();
		foreach ($activities as $key => $activity) {
			if (!($activity instanceof \Querformatik\HelfenKannJeder\Domain\Model\Activity) || !in_array($activity->getUid(), $activityList)) {
				unset($activities[$key]);
			}
		}
		$this->view->assign('activities', $activities);

		$this->view->assign('matrixarray', $matrixA);
		$this->view->assign('activityList', array_unique($activityList));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\ActivityField $activityfield The activity field
	 * @return void
	 */
	public function columnAction(\Querformatik\HelfenKannJeder\Domain\Model\ActivityField $activityfield) {
		$this->view->assign('activityfield', $activityfield);
		$this->view->assign('width', 20);
		$this->view->assign('height', 250);
		$this->view->assign('font', "typo3conf/ext/helfen_kann_jeder/Resources/Private/Fonts/arial.ttf"); // TODO dynamic
	}

	/**
	 * @return void
	 */
	public function backendAction() {

	}

	/**
	 * @return void
	 */
	public function initializeImportAction() {
		$this->excelService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\ExcelService');
		$this->excelService->setActivityfieldRepository($this->activityfieldRepository);
	}

	/**
	 * @return void
	 */
	public function importAction() {
		if ($_FILES["tx_helfenkannjeder_web_helfenkannjederhelfenkannjeder"]["error"]["matrix"] != 0) {
			$this->flashMessageContainer->add("ERROR: Upload error!");
		} else {
			$this->excelService->load($_FILES["tx_helfenkannjeder_web_helfenkannjederhelfenkannjeder"]["tmp_name"]["matrix"]);
			$this->excelService->setActivityfieldRepository($this->activityfieldRepository);
			$this->excelService->setActivityRepository($this->activityRepository);
			if (!$this->excelService->toMatrix()) {
				$this->flashMessageContainer->add("ERROR: ".$this->excelService->getError());
			}
			$matrix = $this->excelService->getMatrix();
			$matrix->setName($this->request->getArgument("name"));
			$this->matrixRepository->add($matrix);
			$this->persistenceManager->persistAll();
			if ($matrix->getUid() != 0) {
				$this->flashMessageContainer->add("Created with uid ".$matrix->getUid());
			}
			$this->redirect('backend');
		}
	}
}
?>
