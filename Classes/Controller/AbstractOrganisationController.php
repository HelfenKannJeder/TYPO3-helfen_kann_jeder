<?php
class Tx_HelfenKannJeder_Controller_AbstractOrganisationController
	extends Tx_Extbase_MVC_Controller_ActionController {

	protected $objectManager;

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


	// Repositories
	protected $addressDraftRepository;
	protected $employeeDraftRepository;
	protected $groupDraftRepository;
	protected $workinghourDraftRepository;

	// Services
	protected $googleMapsService;
	protected $accessControlService;

	// Other
	protected $errorCounter = 0;
	protected $errorFields = array();
	protected $imageFolder = "uploads/tx_helfenkannjeder/";

	/*
	 * LOGO
	 */
	protected function initializeStoreGeneral() {
	}

	protected function storeGeneral(&$organisation) {
		if ($this->request->hasArgument("organisation_logodelete") && $this->request->getArgument("organisation_logodelete") == 1) {
			$organisation->setLogo("");
		}

		if (strpos($organisation->getWebsite(),"://") == false && strlen($organisation->getWebsite()) != 0) {
			$organisation->setWebsite("http://".$organisation->getWebsite());
		}

		if ($this->request->hasArgument("organisation_logoradio")) {
			$mode = $this->request->getArgument("organisation_logoradio");

			if ($mode == "[upload]") {
				$newPicture = $this->handleSingleImage($_FILES["tx_helfenkannjeder_list"], "organisation_logo", 0, "logo");
				if (!empty($newPicture)) {
					$organisation->setLogo($newPicture);
				}
			} else if(file_exists($this->imageFolder.$mode)) {
				$organisation->setLogo($mode);
			}
		}

	}

	/*
	 * ADDRESSES
	 */
	protected function initializeStoreAddresses() {
		$this->addressDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_AddressDraftRepository');

		// Init google maps
		$this->googleMapsService = $this->objectManager->get('Tx_HelfenKannJeder_Service_GoogleMapsService');
		$this->googleMapsService->setGoogleServer($this->settings["googleMapsServer"]);
		$this->googleMapsService->setGoogleApiKey($this->settings["googleMapsApiKey"]);
	}

	protected function storeAddresses(&$organisation) {
		$addresses = $this->request->getArgument("addresses");
		$defaultaddress = -1;
		if ($this->request->hasArgument("defaultaddress")) {
			$defaultaddress = $this->request->getArgument("defaultaddress");
		}
		$defaultaddressObject = null;
		if (is_array($addresses)) {
			foreach ($addresses as $addressKey => $addressData) {
				if (strpos($addressData['website'],"://") == false && strlen($addressData['website']) != 0) {
					$addressData['website'] = "http://".$addressData['website'];
				}

				if (empty($addressData["id"]) && $addressData["delete"] != "1" &&
					!empty($addressData["street"]) && !empty($addressData["city"])) {
					$address = new Tx_HelfenKannJeder_Domain_Model_AddressDraft();
					$address->setStreet($addressData["street"]);
					$address->setCity($addressData["city"]);
					$address->setZipcode($addressData["zipcode"]);
					$address->setAddressappendix($addressData["addressappendix"]);
					$address->setTelephone($addressData["telephone"]);
					$address->setWebsite($addressData['website']);
					$address->validate($this->googleMapsService);
					//if ($address->validate($this->googleMapsService) !== true)
//						$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('register_step40_error_address_not_found', 'HelfenKannJeder'));
					$address->setOrganisation($organisation);
					$organisation->addAddress($address);
				} else {
					$address = $this->addressDraftRepository->findOneByUid($addressData["id"]);
					if ($address instanceof Tx_HelfenKannJeder_Domain_Model_AddressDraft &&
						$address->getOrganisation() instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft &&
						$address->getOrganisation()->getUid() == $organisation->getUid()) {

						if ($addressData["delete"] == "1") {
							$this->addressDraftRepository->remove($address);
						} else {
							if ($address->getStreet() != $addressData["street"] || 
								$address->getCity() != $addressData["city"] || 
								$address->getZipcode() != $addressData["zipcode"]) {
								$address->setStreet($addressData["street"]);
								$address->setCity($addressData["city"]);
								$address->setZipcode($addressData["zipcode"]);
								$address->validate($this->googleMapsService);
								//if ($address->validate($this->googleMapsService) !== true)
								//	$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('register_step40_error_address_not_found', 'HelfenKannJeder'));
							}
							$address->setAddressappendix($addressData["addressappendix"]);
							$address->setTelephone($addressData["telephone"]);
							$address->setWebsite($addressData['website']);
							$this->addressDraftRepository->update($address);
						}
					}
				}
				if ($defaultaddress == $addressKey) {
					$defaultaddressObject = $address;
				}
			}
		}

		$this->persistenceManager->persistAll();

		if (!($defaultaddressObject instanceof Tx_HelfenKannJeder_Domain_Model_AddressDraft)) {
			$defaultaddressObject = $this->addressDraftRepository->findOneByUid($defaultaddress);
		}
		
		if ($defaultaddressObject instanceof Tx_HelfenKannJeder_Domain_Model_AddressDraft
			&& $defaultaddressObject->getOrganisation() instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft
			&& $defaultaddressObject->getOrganisation()->getUid() == $organisation->getUid()) {
			$organisation->setDefaultaddress($defaultaddressObject);
			$organisation->setLongitude($defaultaddressObject->getLongitude());
			$organisation->setLatitude($defaultaddressObject->getLatitude());
		}
	}

	/*
	 * EMPLOYEES
	 */ 
	protected function initializeStoreEmployees() {
		$this->employeeDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeDraftRepository');
	}

	protected function storeEmployees(&$organisation) {
		$employees = $this->request->getArgument("employees");
		if (is_array($employees)) {
			foreach ($employees as $employeeNum => $employeeData) {
				if (empty($employeeData["id"]) && $employeeData["delete"] != "1" &&
					!(empty($employeeData["surname"]) || empty($employeeData["prename"]))) {
					$employee = new Tx_HelfenKannJeder_Domain_Model_EmployeeDraft();
					$employee->setSurname($employeeData["surname"]);
					$employee->setPrename($employeeData["prename"]);
					$employee->setRank($employeeData["rank"]);
					$employee->setMotivation($employeeData["motivation"]);
					$employee->setMail($employeeData["mail"]);
					$employee->setTelephone($employeeData["telephone"]);
					$employee->setMobilephone($employeeData["mobilephone"]);
					$employee->setIscontact($employeeData["iscontact"]);

					$newPicture = $this->handleSingleImage($_FILES["tx_helfenkannjeder_list"], "employees", $employeeNum, "pictures");
					if (!empty($newPicture)) {
						$employee->setPictures($newPicture);
					}

					$organisation->addEmployee($employee);
				} else {
					$employee = $this->employeeDraftRepository->findOneByUid($employeeData["id"]);
					if ($employee instanceof Tx_HelfenKannJeder_Domain_Model_EmployeeDraft &&
						$employee->getOrganisation() instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft &&
						$employee->getOrganisation()->getUid() == $organisation->getUid()) {
						if ($employeeData["delete"] == "1") {
							$this->employeeDraftRepository->remove($employee);
						} else {
							$employee->setSurname($employeeData["surname"]);
							$employee->setPrename($employeeData["prename"]);
							$employee->setRank($employeeData["rank"]);
							$employee->setMotivation($employeeData["motivation"]);
							$employee->setMail($employeeData["mail"]);
							$employee->setTelephone($employeeData["telephone"]);
							$employee->setMobilephone($employeeData["mobilephone"]);
							$employee->setIscontact($employeeData["iscontact"]);

							if (isset($employeeData["picturesdelete"]) && $employeeData["picturesdelete"] == 1) {
								$employee->setPictures("");
							}

							$newPicture = $this->handleSingleImage($_FILES["tx_helfenkannjeder_list"], "employees", $employeeNum, "pictures");
							if (!empty($newPicture)) {
								$employee->setPictures($newPicture);
							}

							$this->employeeDraftRepository->update($employee);
						}
					}
				}
			}
		}
		$employeesPersist = $organisation->getEmployees();
		$organisation->removeAllContactpersons();
		foreach ($employeesPersist as $employee) {
			if ($employee->getIscontact() == 1) {
				$organisation->addContactperson($employee);
			}
		}

	}

	/*
	 * GROUPS
	 */
	protected function initializeStoreGroups() {
		$this->employeeDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_EmployeeDraftRepository');
		$this->groupDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupDraftRepository');
	}

	protected function storeGroups($organisation) {
		if ($this->request->hasArgument("groups")) {
			$groups = $this->request->getArgument("groups");
                        $groupNum = 1;

			$groupTemplateCategories = $organisation->getOrganisationtype()->getGroupTemplateCategories();
			$groupTemplateCategories = $groupTemplateCategories->toArray();
			usort($groupTemplateCategories, array(&$this, "storeGroupsSortGroups"));
			foreach ($groupTemplateCategories as $groupTemplateCategory) {
				$groupTemplates = $groupTemplateCategory->getGroupTemplates();
				$groupTemplates = $groupTemplates->toArray();
				usort($groupTemplates, array(&$this, "storeGroupsSortGroups"));
				foreach ($groupTemplates as $groupTemplate) {
					$groupInfoFromUser = $groups[$groupTemplateCategory->getUid()][$groupTemplate->getUid()];
                        
					$groupObjects = $this->groupDraftRepository->findByOrganisationAndTemplate($organisation, $groupTemplate);
					$groupObject = null;
					$groupObjectCreate = true;
					$groupObjectWanted = ($groupInfoFromUser["checked"] == 1);
                        
					foreach ($groupObjects as $groupObjectFound) {
						$groupObject = $groupObjectFound;
						$groupObjectCreate = false;
					}
                        
					if ($groupObjectCreate) {
						$groupObject = new Tx_HelfenKannJeder_Domain_Model_GroupDraft();
						$groupObject->setTemplate($groupTemplate);
						$groupObject->setOrganisation($organisation);
					}
                        
					$groupObject->setName($groupTemplate->getName());
					$groupObject->setMatrix($groupTemplate->getMatrix());
					$groupObject->setDescription($groupInfoFromUser["description"]);
					$groupObject->setWebsite($groupInfoFromUser["website"]);
					if (strpos($groupObject->getWebsite(),"://") == false && strlen($groupObject->getWebsite()) != 0) {
						$groupObject->setWebsite("http://".$groupObject->getWebsite());
					}
					$groupObject->setMinimumAge($groupInfoFromUser["minimum_age"]);
					$groupObject->setMaximumAge($groupInfoFromUser["maximum_age"]);

					$groupObject->removeAllContactpersons();
					if (is_array($groupInfoFromUser["contact"])) {
						$contactObjects = $groupObject->getContactpersons();
                        
						foreach ($groupInfoFromUser["contact"] as $contactId) {
							$contact = $this->employeeDraftRepository->findByOrganisationAndUid($organisation, $contactId)->getFirst();
							$groupObject->addContactperson($contact);
						}
					}
                        
					if (!is_null($groupObject)) {
						if (!$groupObjectCreate && !$groupObjectWanted && $groupObject instanceof Tx_HelfenKannJeder_Domain_Model_GroupDraft) {
							$this->groupDraftRepository->remove($groupObject);
						} else if ($groupObjectCreate && $groupObjectWanted) {
                        				$groupObject->setSort($groupNum++);
							$this->groupDraftRepository->add($groupObject);
						} else if (!$groupDraftRepository && $groupObjectWanted) {
                        				$groupObject->setSort($groupNum++);
							$this->groupDraftRepository->update($groupObject);
						}
					}
				}
			}

			$this->persistenceManager->persistAll();
			foreach ($organisation->getGroups() as $groupObject) {
				if (!($groupObject->getTemplate() instanceof Tx_HelfenKannJeder_Domain_Model_GroupTemplate)) {
					$this->groupDraftRepository->remove($groupObject);
				}
			}
		}
	}

	protected function storeGroupsSortGroups($a, $b) {
		$sortBy = "getSort";
		if (method_exists($a, $sortBy) && method_exists($b, $sortBy)) {
			$valueA = call_user_func(array($a, $sortBy));
			$valueB = call_user_func(array($b, $sortBy));

			return ($valueA >= $valueB);
		} else {
			return 0;
		}
	}

	/*
	 * WORKINGHOURS
	 */
	protected function initializeStoreWorkinghours() {
		$this->groupDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_GroupDraftRepository');
		$this->workinghourDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_WorkinghourDraftRepository');
	}

	protected function storeWorkinghours($organisation) {
		$workinghours = $this->request->getArgument("workinghours");
		if (is_array($workinghours)) {
			foreach ($workinghours as $workinghourData) {
				if (empty($workinghourData["id"]) && $workinghourData["delete"] != "1" &&
					!empty($workinghourData["day"])) {
					$workinghour = new Tx_HelfenKannJeder_Domain_Model_WorkinghourDraft();
					$workinghour->setOrganisation($organisation);
					$workinghour->setDay(            $workinghourData["day"]);
					$workinghour->setStarttimehour(  $workinghourData["starttimehour"]);
					$workinghour->setStarttimeminute($workinghourData["starttimeminute"]);
					$workinghour->setStoptimehour(   $workinghourData["stoptimehour"]);
					$workinghour->setStoptimeminute( $workinghourData["stoptimeminute"]);
					$workinghour->setAddress(	 $workinghourData["address"]);
					$organisation->addWorkinghour($workinghour);
					$workinghour->setAddition(       $workinghourData["addition"]);

					$workinghour->removeAllGroups();
					foreach ($workinghourData["groups"] as $groupUid) {
						$group = $this->groupDraftRepository->findOneByUid($groupUid);
						if (!$workinghour->getGroups()->contains($group)) {
							$workinghour->addGroup($group);
						}
					}
					$this->workinghourDraftRepository->add($workinghour);
				} else {
					$workinghour = $this->workinghourDraftRepository->findOneByUid($workinghourData["id"]);
					if ($workinghour instanceof Tx_HelfenKannJeder_Domain_Model_WorkinghourDraft &&
						$workinghour->getOrganisation() instanceof Tx_HelfenKannJeder_Domain_Model_OrganisationDraft &&
						$workinghour->getOrganisation()->getUid() == $organisation->getUid()) {
						if ($workinghourData["delete"] == "1") {
							$this->workinghourDraftRepository->remove($workinghour);
						} else {
							$workinghour->setDay(            $workinghourData["day"]);
							$workinghour->setStarttimehour(  $workinghourData["starttimehour"]);
							$workinghour->setStarttimeminute($workinghourData["starttimeminute"]);
							$workinghour->setStoptimehour(   $workinghourData["stoptimehour"]);
							$workinghour->setStoptimeminute( $workinghourData["stoptimeminute"]);
							$workinghour->setAddition(       $workinghourData["addition"]);
							$workinghour->setAddress(	 $workinghourData["address"]);

							$workinghour->removeAllGroups();
							foreach ($workinghourData["groups"] as $groupUid) {
								$group = $this->groupDraftRepository->findOneByUid($groupUid);
								if (!$workinghour->getGroups()->contains($group)) {
									$workinghour->addGroup($group);
								}
							}

							$this->workinghourDraftRepository->update($workinghour);
						}
					}
				}
			}
		}
		$this->persistenceManager->persistAll();
	}

	/*
	 * IMAGE HANDLING
	 */
	// Should use Tx_QuBase_Controller_AbstractController->handleSingleFile
	protected function handleSingleImage($file, $objectType, $objectNum, $attribute) {
		if (isset($file["name"][$objectType][$objectNum][$attribute])) {
			switch ($file["error"][$objectType][$objectNum][$attribute]) {
				case  UPLOAD_ERR_INI_SIZE:
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error_organisation_upload_failed_image_size_ini', 'HelfenKannJeder'));
					break;
				case  UPLOAD_ERR_FORM_SIZE:
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error_organisation_upload_failed_image_size_form', 'HelfenKannJeder'));
					break;
				case  UPLOAD_ERR_PARTIAL:
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error_organisation_upload_failed_internal_problem_partial', 'HelfenKannJeder'));
					break;
				case  UPLOAD_ERR_NO_TMP_DIR:
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error_organisation_upload_failed_internal_problem_tmp_dir', 'HelfenKannJeder'));
					break;
				case  UPLOAD_ERR_CANT_WRITE:
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error_organisation_upload_failed_internal_problem_write', 'HelfenKannJeder'));
					break;
				case  UPLOAD_ERR_EXTENSION:
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error_organisation_upload_failed_internal_problem_extension', 'HelfenKannJeder'));
					break;
				case  UPLOAD_ERR_NO_FILE:
					break;
				default:
					$imageInfo = @getimagesize($file['tmp_name'][$objectType][$objectNum][$attribute]);

					if ($imageInfo == false || !in_array($imageInfo[2], array(IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
						// TODO error
						$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error_organisation_upload_failed_wrong_image_type', 'HelfenKannJeder'));
						return "";
					}

					$basicFileFunctions = $this->objectManager->get('t3lib_basicFileFunctions');

					$file['name'][$objectType][$objectNum][$attribute] = preg_replace('/[^\w\._]+/', '_', $file['name'][$objectType][$objectNum][$attribute]);
					$fileName = $basicFileFunctions->getUniqueName($file['name'][$objectType][$objectNum][$attribute],
						t3lib_div::getFileAbsFileName('uploads/tx_helfenkannjeder/')); // TODO dynamic
 
					t3lib_div::upload_copy_move($file['tmp_name'][$objectType][$objectNum][$attribute], $fileName);
					return basename($fileName);
			}
		} else {
			return "";
		}
	}

	/**
	 * @return void
	 */
	public function initializeUploadAction() {
		$this->organisationDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository');
	}

	/**
	 * Handles uploads from plupload component.
	 *
	 * @param Tx_HelfenKannJeder_Domain_Model_OrganisationDraft $organisation
	 * @param string $session
	 * @ignorevalidation $organisation
	 * @return string
	 * @api
	 */
	public function uploadAction($organisation, $session) {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		if ($organisation->getHash() == $session) {
			// Settings
			$targetDir = $this->imageFolder; //ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
			//$targetDir = 'uploads';
                
			// Get parameters
			$fileName = isset($_POST["Filename"]) ? $_POST["Filename"] : '';
                
			// Clean the fileName for security reasons
			$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
                
			// Make sure the fileName is unique but only if chunking is disabled
			if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
				$ext = strrpos($fileName, '.');
				$fileName_a = substr($fileName, 0, $ext);
				$fileName_b = substr($fileName, $ext);
                
				$count = 1;
				while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
					$count++;
                
				$fileName = $fileName_a . '_' . $count . $fileName_b;
			}
                
			$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
                
			// Create target dir
			if (!file_exists($targetDir))
				@mkdir($targetDir);
                
			$uploaded = false;
			if (!empty($fileName)) {
				if (!file_exists($filePath) && isset($_FILES["import"]["tmp_name"])) {
					$fileInfo = getimagesize($_FILES["import"]["tmp_name"]);
					if (($fileInfo[2] == IMAGETYPE_PNG || $fileInfo[2] == IMAGETYPE_JPEG)
						&& $fileInfo[1] >= 600 && $fileInfo[0] >= 600) {
						$uploaded = move_uploaded_file($_FILES["import"]["tmp_name"], $filePath);
					}
				}
			}
			if ($uploaded === TRUE) {
				$pictures = $organisation->getPictures();
				if (empty($pictures)) {
					$pictures = $fileName;
				} else {
					$pictures .= ",".$fileName;
				}
				$pictures = trim($pictures);
                
				$pictures = implode(",",array_unique(explode(",",$pictures)));
				$organisation->setPictures($pictures);
				$this->organisationDraftRepository->update($organisation);
				$this->view->assign("uploadStatus", "uploadSuccess");
				$this->view->assign("imageFolder", $this->imageFolder);
				$this->view->assign("picture", $fileName);
			} else {
				$this->view->assign("uploadStatus", "uploadFailed");
			}
		} else {
			$this->view->assign("uploadStatus", "uploadFailed");
		}
	}

	protected function getBrowser() {
		return "not_available";
	}

	protected function initializeStorePictures() {
		$this->organisationDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository');
	}

	protected function storePictures($organisation) {
		$fileName = $this->handleSingleImage($_FILES["tx_helfenkannjeder_list"], "organisation_picture", 0, "picture");
		if (!empty($fileName)) {
			$pictures = $organisation->getPictures();
			if (empty($pictures)) {
				$pictures = $fileName;
			} else {
				$pictures .= ",".$fileName;
			}
			$pictures = trim($pictures);
                
			$pictures = implode(",",array_unique(explode(",",$pictures)));
			$organisation->setPictures($pictures);
		}

		$this->organisationDraftRepository->update($organisation);

	}

	/*
	 * GENERATION FUNCTIONS
	 */
	protected function generateUsername($acronym, $cityInfo, $department="", $namedisplay = "") {
		$listedCitys = $this->googleMapsService->calculateCityAndDepartment("Germany, ".$cityInfo["locality"]." ".$cityInfo["sublocality"]);
		$username = $acronym;
		$organisationname = $namedisplay;

		if (count($listedCitys) > 1) {
			if (isset($cityInfo["administrative_area_level_3"]) && !empty($cityInfo["administrative_area_level_3"])) {
				$cityInfo["administrative_area_level_2"] = $cityInfo["administrative_area_level_3"];
			}
			$username .= "-".$cityInfo["administrative_area_level_2"];
			$organisationname .= " ".$cityInfo["administrative_area_level_2"];
		}
		if ((string)$cityInfo["locality"] != (string)$cityInfo["administrative_area_level_2"] || count($listedCitys) == 1) {
			$username .= "-".$cityInfo["locality"];
			$organisationname .= " ".$cityInfo["locality"];
		}

		if (isset($cityInfo["sublocality"]) && (string)$cityInfo["locality"] != (string)$cityInfo["sublocality"]) {
			$username .= "-".$cityInfo["sublocality"];
			$organisationname .= " ".$cityInfo["sublocality"];
		}

		if (!empty($department)) {
			$username .= "-".$department;
			$organisationname = trim($organisationname);
			$organisationname .= ", ".Tx_Extbase_Utility_Localization::translate('organisation_department', 'HelfenKannJeder')." ".$department;
		}
		$username = utf8_decode(strtolower($username));
		$username = preg_replace_callback("/([^a-z-0-9])/si", array(&$this, "changeSpecialChars"), $username);
		$username = strtolower($username);
		return array($username, trim($organisationname));
	}

	protected function changeSpecialChars($chars) {
		$char = $chars[1];
		$return = "";
		switch ($char) {
			case utf8_decode("Ä"): $return = "Ae"; break;
			case utf8_decode("Ö"): $return = "Oe"; break;
			case utf8_decode("Ü"): $return = "Ue"; break;
			case utf8_decode("ä"): $return = "ae"; break;
			case utf8_decode("ö"): $return = "oe"; break;
			case utf8_decode("ü"): $return = "ue"; break;
			case utf8_decode("ß"): $return = "ss"; break;
			case " ": $return = "-"; break;
		}
		return $return;
	}

	protected function generateRandomHash() {
		$allChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$randomString = "";
		for ($i=0;$i<8;$i++) {
			$randomString .= $allChars{mt_rand(0,strlen($allChars))};
		}
		return $randomString;
	}

	/*
	 * VALIDATION
	 */
	protected function pageChangeAllowed() {
		return !$this->hasErrors() || ($this->request->hasArgument("forcePageChange") && $this->request->getArgument("forcePageChange") == "1");
	}

	protected function callValidator($name, $object, $prefix = "", $match = 0) {
		$className = "Tx_HelfenKannJeder_Domain_Validator_".$name."Validator";
		if (class_exists($className)) {
			$validator = new $className();
			$validator->setMatch($match);
			$result = $validator->isValid($object);

			if (!$result) {
				$this->errorFields = array_merge($this->errorFields, $validator->getInvalidFields());

				foreach ($validator->getErrors() as $error) {
					$this->flashMessageContainer->add($prefix.$error->getMessage());
					$this->errorCounter++;
				}
			}
		}
	}

	public function hasErrors() {
		return $this->errorCounter > 0;
	}

	public function getErrorFields() {
		return $this->errorFields;
	}

	public function getErrorFieldsAndClear() {
		$errorFields = $this->errorFields;
		$this->errorFields = array();
		return $errorFields;
	}

	public function clearErrorFields() {
		$this->errorFields = array();
	}

	protected function restoreRequestTime($organisation) {
		$organisationOrginal = $this->organisationDraftRepository->findByUid($organisation->getUid());
		$organisation->setRequest($organisationOrginal->getRequest());
		$organisation->setRequesttime($organisationOrginal->getRequesttime());
		$organisation->setSupporter($organisationOrginal->getSupporter());
		return $organisationOrginal;
	}
}
?>
