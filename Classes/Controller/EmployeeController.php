<?php
class Tx_HelfenKannJeder_Controller_EmployeeController
	extends Tx_Extbase_MVC_Controller_ActionController {
	protected $organisationRepository;
	protected $employeeRepository;
	protected $configurationManager;
	protected $contentObject;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository');
		$this->employeeRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeRepository');

		$this->configurationManager = $this->objectManager->get("Tx_Extbase_Configuration_ConfigurationManager");
		$this->contentObject = $this->configurationManager->getContentObject();
	}

	public function indexAction() {
		// TODO: Bilder Pfad (uploads/pics/) aus Templates auslagern

		$rotatingEmployees = array();
		$defaultEmployee = $this->employeeRepository->findByUid($this->settings["defaultEmployee"]);

		$rotatingEmployees[0] = $this->buildArrayEntry($defaultEmployee);

		$this->view->assign('rotatingEmployees', $rotatingEmployees);
	}

	/**
	 * @param Tx_HelfenKannJeder_Domain_Model_Employee $employee Employee to display
	 * @return void
	 */
	public function detailAction(Tx_HelfenKannJeder_Domain_Model_Employee $employee) {
		$this->view->assign('employee', $employee);
	}

	// TODO: Duplicate code!
	private function convertImage($picture) {
		if (!empty($picture)) {
			$src = "uploads/pics/".$picture;
			$width = 61;
			$height = 74;
			$minWidth = $width;
			$minHeight = $height;
			$maxWidth = $width;
			$maxHeight = $height;
                
			$setup = array(
				'width' => $width."c",
				'height' => $height."c",
				'minW' => $minWidth,
				'minH' => $minHeight,
				'maxW' => $maxWidth,
				'maxH' => $maxHeight
			);
			if (TYPO3_MODE === 'BE' && substr($src, 0, 3) === '../') {
				$src = substr($src, 3);
			}
			$imageInfo = $this->contentObject->getImgResource($src, $setup);
			$GLOBALS['TSFE']->lastImageInfo = $imageInfo;
			if (!is_array($imageInfo)) {
				throw new Tx_Fluid_Core_ViewHelper_Exception('Could not get image resource for "' . htmlspecialchars($src) . '".' , 1253191060);
			}
			$GLOBALS['TSFE']->imagesOnPage[] = $imageInfo[3];
			return $imageInfo[3];
		}
	}

	private function buildArrayEntry($employee) {
		$prefix = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . 'employeedetail');
		$arguments = array(
			$prefix => array(
				'action' => 'detail',
				'controller' => 'Employee',
				'employee' => $employee->getUid()
			)
		);
		return array(
			"text" => $employee->getTeaser(),
			"picture" => $this->convertImage($employee->getPictures()),
			"name" => trim($employee->getPrename()." ".$employee->getSurname()),
			"rank" => $employee->getRank(),
			"link"=>$this->uriBuilder->reset()->setTargetPageUid($this->settings["defaultEmployeeDetailPage"])->setArguments($arguments)->uriFor('', array())
		);
	}
}
?>