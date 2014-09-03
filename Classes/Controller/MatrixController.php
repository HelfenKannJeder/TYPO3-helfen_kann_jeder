<?php
class Tx_HelfenKannJeder_Controller_MatrixController
	extends Tx_Extbase_MVC_Controller_ActionController {
	protected $accessControlService;
	protected $matrixService;
	protected $matrixRepository;
	protected $activityRepository;
	protected $activityfieldRepository;
	protected $excelService;

	/**
	 * @var Tx_Extbase_Persistence_ManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * injectPersistenceManager
	 *
	 * @param Tx_Extbase_Persistence_ManagerInterface $persistenceManager
	 */
	public function injectPersistenceManager(Tx_Extbase_Persistence_ManagerInterface $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('Tx_HelfenKannJeder_Service_AccessControlService');
		$this->matrixService = $this->objectManager->get('Tx_HelfenKannJeder_Service_MatrixService');

		$this->matrixRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_MatrixRepository');

		$this->activityRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_ActivityRepository');
		$this->activityRepository->setDefaultOrderings(array('name'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));

		$this->activityfieldRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_ActivityFieldRepository');
		$this->activityfieldRepository->setDefaultOrderings(array('name'=>Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Organisation $organisation The matrix to edit
	 * @return void
	 */
	public function viewAction(Tx_HelfenKannJeder_Domain_Model_Organisation $organisation) {
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
			if (!($activity instanceof Tx_HelfenKannJeder_Domain_Model_Activity) || !in_array($activity->getUid(), $activityList)) {
//				echo "ok";
				unset($activities[$key]);
			}
		}
		$this->view->assign('activities', $activities);

		$this->view->assign('matrixarray', $matrixA);
		$this->view->assign('activityList', array_unique($activityList));
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_ActivityField $activityfield The activity field
	 * @return void
	 */
	public function columnAction(Tx_HelfenKannJeder_Domain_Model_ActivityField $activityfield) {
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
		$this->excelService = $this->objectManager->get('Tx_HelfenKannJeder_Service_ExcelService');
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
