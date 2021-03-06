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

class RegisterController
	extends AbstractOrganisationController {
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

	/**
	 * Log manager to log it when mail sending failed.
	 *
	 * @var TYPO3\CMS\Core\Log\LogManager
	 * @inject
	 */
	protected $logManager;

	protected $accessControlService;
	protected $frontendUser;
	protected $registerOrganisationProgressRepository;
	protected $registerOrganisationProgress;
	protected $supportService;
	protected $addressDraftRepository;
	protected $employeeDraftRepository;
	protected $organisationDraftRepository;
	protected $organisationTypeRepository;
	protected $workinghourDraftRepository;
	protected $groupDraftRepository;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 */
	protected $frontendUserRepository;
	protected $frontendUserGroupRepository;
	protected $activityRepository;
	protected $activityfieldRepository;
	protected $mailService;
	protected $googleMapsService;
	protected $matrixService;
	protected $stepBack = FALSE;
	protected $stepSave = FALSE;
	protected $steps = array(10, 20, 21, 30, 31, 32, 33, 40, 50, 60, 70, 80);

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService'); // Singleton
		$this->frontendUser = $this->accessControlService->getFrontendUser();

		$this->registerOrganisationProgressRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\RegisterOrganisationProgressRepository');
		if ($this->accessControlService->hasLoggedInFrontendUser()) {
			$this->registerOrganisationProgress = $this->registerOrganisationProgressRepository->findOneByFeuser($this->frontendUser);
		} else {
			$this->registerOrganisationProgress = $this->registerOrganisationProgressRepository->findByUid($this->accessControlService->getSessionVariable('registerOrganisationProgress'));
		}


		$this->supportService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\SupportService');
		$this->supportService->setDefaultSupporter($this->settings['supporterDefault']);
		$this->addressDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\AddressDraftRepository');
		$this->employeeDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeDraftRepository');
		$this->organisationDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationDraftRepository');
		$this->organisationTypeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationTypeRepository');
		$this->workinghourDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\WorkinghourDraftRepository');
		$this->groupDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupDraftRepository');
		$this->groupDraftRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		$this->frontendUserRepository = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
		$this->frontendUserGroupRepository = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserGroupRepository');
		$this->activityRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\ActivityRepository');
		$this->activityfieldRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\ActivityFieldRepository');

		$this->mailService = $this->objectManager->get('\\Tx_QuBase_Service_MailService');
		$this->mailService->setFrom($this->settings['mailFrom']);
		$this->googleMapsService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\GoogleMapsService');

		$this->matrixService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\MatrixService');

		if ($this->request->hasArgument('stepBack')) {
			$this->stepBack = TRUE;
		}
		if ($this->request->hasArgument('stepSave')) {
			$this->stepSave = TRUE;
		}
	}

	function errorAction() {
		if ($this->stepBack == TRUE && $this->registerOrganisationProgress instanceof \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress
			&& $this->actionMethodName == 'sendstep'.$this->registerOrganisationProgress->getFinisheduntil().'Action') {
			$currentStep = substr($this->actionMethodName,8,2);
			$positionStep = array_search($currentStep, $this->steps)-1;

			if (isset($this->steps[$positionStep])) {
				$previousStep = $this->steps[$positionStep];

				$this->redirect('showstep'.$previousStep, NULL, NULL, array('registerOrganisationProgress' => $this->registerOrganisationProgress, 'stepBack' => 'redirect'));
			} else {
				return parent::errorAction();
			}
		} else {
			return parent::errorAction();
		}
	}

	/**
	 * If you need a multi-step form which updates a domain object, you only want properties validated which are
	 * sent with the current request. This method should be called in the corresponding initialize*Action,
	 * and it will rebuild the registered validators for this argument.
	 *
	 * It will also respect the @validate annotation on the action method name.
	 *
	 * THIS METHOD WILL NOT CHECK A @ignorevalidation ANNOTATION. Thus, it should NOT be used
	 * for displaying a form, but instead be used for SAVING data.
	 *
	 * @param string $argumentName The name of the argument where the partial validator should be registered for.
	 */
	protected function registerPartialValidatorForArgument($argumentName) {
		if ($this->request->hasArgument($argumentName)) {
			// Initialize the extended validator resolver.
			$extendedValidatorResolver = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Validation\\ExtendedValidatorResolver');

			// Load all parameter validators and pick the one for the current argument, as this is the base validator.
			$parameterValidators = $this->validatorResolver->buildMethodArgumentsValidatorConjunctions(get_class($this), $this->actionMethodName);

			$baseValidator = $parameterValidators[$argumentName];

			// Build up the validator for all submitted data.
			$rawRequestDataForArgument = $this->request->getArgument($argumentName);
			$argument = $this->arguments[$argumentName];
			$partialValidator = $extendedValidatorResolver->buildBaseValidatorConjunctionWithRequestData($argument->getDataType(), $rawRequestDataForArgument);

			// Add the partial validator to the base validator; and override the validations of the argument.
			$baseValidator->addValidator($partialValidator);
			$argument->setValidator($baseValidator);
		}
	}

	protected function registerHandleProveRegisterOrganisationType($registerOrganisationType) {
		if (!($registerOrganisationType instanceof \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress
			&& $this->registerOrganisationProgress instanceof \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress
			&& $registerOrganisationType->getSessionid() == $this->registerOrganisationProgress->getSessionid()
			&& $registerOrganisationType->getUid() == $this->registerOrganisationProgress->getUid()
			&& $registerOrganisationType->getFinisheduntil() < 40)) {
			$this->redirect('showstep10');
		}
	}

	protected function registerHandleLoggedInUser() {
		$this->redirect('', NULL, NULL, array(), $this->settings['loggedInMainSite'], 0);
	}

	protected function registerHandleProveAccess($registerOrganisationProgress, $organisation, $forceAll = TRUE) {
		if ($registerOrganisationProgress == NULL) {
			$registerOrganisationProgress = $this->registerOrganisationProgress;
		}
		if ($registerOrganisationProgress instanceof \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress) {
			if ($organisation == NULL) {
				$organisation = $registerOrganisationProgress->getOrganisation();
			}

			if (!$forceAll && $this->accessControlService->isLoggedIn($registerOrganisationProgress->getFeuser())) {
				return TRUE;
			}

			if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
				&& $organisation->getOrganisationtype() instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType
				&& $this->accessControlService->isLoggedIn($registerOrganisationProgress->getFeuser())
				&& $this->accessControlService->isLoggedIn($organisation->getFeuser())) {
				return TRUE;
			}
		}
		$this->redirect('showstep10', NULL, NULL, array(), $this->settings['registerOrganisationStepsPart1']);
		return FALSE;
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgressStep10 $step10
	 * @return void
	 * @ignorevalidation $step10
	 */
	public function showstep10Action($step10 = NULL) {
		if ($this->accessControlService->hasLoggedInFrontendUser()) {
			$this->registerHandleLoggedInUser();
		}

		$this->accessControlService->removeSessionVariable('registerOrganisationProgress');

		$registerOrganisationProgress = new \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress($this->accessControlService->getSessionId());
		$registerOrganisationProgress->setLaststep(10);
		$registerOrganisationProgress->setFinisheduntil(10);
                
		$this->view->assign('step', 10);
		$this->view->assign('actionSendMethod', 'sendstep10');
		$this->view->assign('headline', 'register_step1_headline');
		$this->view->assign('objectEditName', 'step10');
		$this->view->assign('objectEdit', NULL);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array());
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgressStep10 $step10
	 * @return void
	 */
	public function sendstep10Action($step10) {
		if ($this->accessControlService->hasLoggedInFrontendUser()) {
			$this->registerHandleLoggedInUser();
		}

		//$this->flashMessageContainer->flush();
		$location = array(0 => array ('country' => 'Deutschland'));

		$registerOrganisationProgress = new \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress($this->accessControlService->getSessionId());
		$registerOrganisationProgress->setLaststep(10);
		$registerOrganisationProgress->setFinisheduntil(20);
		$registerOrganisationProgress->setAgreement(TRUE);
		$registerOrganisationProgress->setSupporter($this->supportService->findSupporter($location, $this->settings['supporterGroup']));

		$this->registerOrganisationProgressRepository->add($registerOrganisationProgress);
		$this->persistenceManager->persistAll();

		$this->accessControlService->setSessionVariable('registerOrganisationProgress', $registerOrganisationProgress->getUid());
		$this->redirect('showstep20', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @ignorevalidation $registerOrganisationProgress
	 * @return void
	 */
	public function showstep20Action($registerOrganisationProgress) {
		if ($this->accessControlService->hasLoggedInFrontendUser()) {
			$this->registerHandleLoggedInUser();
		}

		$this->registerHandleProveRegisterOrganisationType($registerOrganisationProgress);
		$registerOrganisationProgress->setLaststep(20);

		$dummyObject = new \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType();
		$dummyObject->setName(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step2_please_choose', 'HelfenKannJeder'));

		$organisationTypes = $this->organisationTypeRepository->findByRegisterable(1);
		$organisationTypesList = array();
		$organisationTypesList[] = $dummyObject;
		foreach ($organisationTypes as $organisationType) {
			$organisationTypesList[] = $organisationType;
		}

		$this->view->assign('step', 20);
		$this->view->assign('actionSendMethod', 'sendstep31');
		$this->view->assign('headline', 'register_step2_headline');
		$this->view->assign('objectEditName', 'registerOrganisationProgress');
		$this->view->assign('objectEdit', $registerOrganisationProgress);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('organisationType', $organisationTypesList);
		$this->view->assign('args', array());
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @return void
	 */
	public function sendstep31Action($registerOrganisationProgress) {
		if ($this->accessControlService->hasLoggedInFrontendUser()) {
			$this->registerHandleLoggedInUser();
		}

		$this->registerHandleProveRegisterOrganisationType($registerOrganisationProgress);

		$errors = FALSE;

		$listedCitys = $this->googleMapsService->calculateCityAndDepartment('Germany, '.$registerOrganisationProgress->getCity());

		if ($this->stepBack) {
			$this->accessControlService->removeSessionVariable('registerOrganisationProgress');

			$this->redirect('', NULL, NULL, array('registerOrganisationProgress' => NULL), $this->settings['loggedInMainSite']);
			return;
		}

		if (!($registerOrganisationProgress->getOrganisationtype() instanceof \Querformatik\HelfenKannJeder\Domain\Model\OrganisationType)) {
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error_registerorganisationprogress_missing_organisationtype', 'HelfenKannJeder'));
			$errors = TRUE;
		}

		if (!is_numeric($registerOrganisationProgress->getCity()) || strlen($registerOrganisationProgress->getCity()) != 5) {
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error_registerorganisationprogress_wrong_zipcode', 'HelfenKannJeder'));
			$errors = TRUE;
		}

		if (!preg_match('/^[A-Za-z\-0-9]+$/si', $registerOrganisationProgress->getUsername())) {
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error_registerorganisationprogress_invalid_username', 'HelfenKannJeder'));
			$errors = TRUE;
		}

		if (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/si',
				$registerOrganisationProgress->getMail())) {
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error_registerorganisationprogress_invalid_mail', 'HelfenKannJeder').$registerOrganisationProgress->getMail());
			$errors = TRUE;
		}

		if ($registerOrganisationProgress->getSurname() == '' || $registerOrganisationProgress->getPrename() == '') {
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error_registerorganisationprogress_missing_name', 'HelfenKannJeder'));
			$errors = TRUE;
		}

		if (count($listedCitys) == 1 && $listedCitys[0]['locality'] != '') {
			list($username, $organisationName) = $this->generateUsername($registerOrganisationProgress->getOrganisationtype()->getAcronym(), $listedCitys[0], $registerOrganisationProgress->getDepartment(), $registerOrganisationProgress->getOrganisationtype()->getNamedisplay());
			$username = strtolower($registerOrganisationProgress->getUsername());
			$cityInfo = $listedCitys[0];
			$name = $cityInfo['postal_code'];

			$registerOrganisationProgress->setCity($name);
			$registerOrganisationProgress->setLongitude($cityInfo['longitude']);
			$registerOrganisationProgress->setLatitude($cityInfo['latitude']);
			if ($this->frontendUserRepository->countByUsername($username) > 0) {
				$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step3_error_missing_department', 'HelfenKannJeder')
							.$registerOrganisationProgress->getSupporter()->getName()
							.\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step3_error_missing_department_mail', 'HelfenKannJeder')
							.$registerOrganisationProgress->getSupporter()->getEMail().'.');
				$errors = TRUE;
				$redirectTo = 'showstep20';
			} else {
				$registerOrganisationProgress->setUsername($username);
				if ($registerOrganisationProgress->getOrganisationname() == '') {
					$registerOrganisationProgress->setOrganisationname($organisationName);
				}
			}
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
		} else {
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step3_error_nothing_found', 'HelfenKannJeder'));
			$errors = TRUE;
		}

		$percentMax = 0;
		$similarMax = '';
		$words = array($registerOrganisationProgress->getUsername(), 'password', 'passwort', 'test', 'abc123', '123qwe', '12345');

		foreach ($words as $word) {
			similar_text($registerOrganisationProgress->getPassword(), $word, $percent);
			$percentMax = max($percentMax, $percent);
			if ($percentMax == $percent) {
				$similarMax = $word;
			}
		}

		if (strlen($registerOrganisationProgress->getPassword()) < 8
				&& !($registerOrganisationProgress->getPassword() == ''
				&& $registerOrganisationProgress->getPassword2() == ''
				&& $registerOrganisationProgress->getPasswordSaved())) {
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step31_error_password_to_short', 'HelfenKannJeder'));
			$errors = TRUE;
			$registerOrganisationProgress->setPassword('');
			$registerOrganisationProgress->setPassword2('');
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
		}
		if ($percentMax >= 80) {
			$this->flashMessageContainer->add(sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step31_error_password_match_word', 'HelfenKannJeder'), $similarMax));
			$errors = TRUE;
			$registerOrganisationProgress->setPassword('');
			$registerOrganisationProgress->setPassword2('');
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
		}


		if ($registerOrganisationProgress->getPassword() != $registerOrganisationProgress->getPassword2()
				&& !($registerOrganisationProgress->getPassword() == ''
				&& $registerOrganisationProgress->getPassword2() == ''
				&& $registerOrganisationProgress->getPasswordSaved())) {
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step31_error_passwords_not_match', 'HelfenKannJeder'));
			$errors = TRUE;
			$registerOrganisationProgress->setPassword('');
			$registerOrganisationProgress->setPassword2('');
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
		} 

		if (!$errors) {
			if ($registerOrganisationProgress->getPassword() == '') {
				$passwordRestore = $this->registerOrganisationProgress->getPassword();
				$registerOrganisationProgress->setPassword($passwordRestore);
				$registerOrganisationProgress->setPassword2($passwordRestore);
			}

			$registerOrganisationProgress->setPasswordSaved(TRUE);

			if ($this->frontendUserRepository->countByUsername($registerOrganisationProgress->getUsername()) > 0) {
				$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step31_error_user_exists', 'HelfenKannJeder'));
				$registerOrganisationProgress->setPassword('');
				$registerOrganisationProgress->setPassword2('');
				$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
				$this->redirect('showstep20', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress));
			} else {
				// Register User, this step is not reversable!
				$feUser = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser($registerOrganisationProgress->getUsername(), $registerOrganisationProgress->getPassword());
				$feUser->addUsergroup($this->frontendUserGroupRepository->findByUid($this->settings['registerProgressUserGroup']));
                                $feUser->setZip($registerOrganisationProgress->getCity());
                                $feUser->setName($registerOrganisationProgress->getPrename().' '.$registerOrganisationProgress->getSurname());
                                $feUser->setFirstName($registerOrganisationProgress->getPrename());
				$feUser->setLastName($registerOrganisationProgress->getSurname());
				$feUser->setEmail($registerOrganisationProgress->getMail());
				$this->frontendUserRepository->add($feUser);
				$this->persistenceManager->persistAll();
                
				$registerOrganisationProgress->setFeuser($feUser);
				$randomHash = $this->generateRandomHash();
                                $registerOrganisationProgress->setMailHash($randomHash);
				$linkToContinue = $this->uriBuilder->setTargetPageUid($this->settings['registerOrganisationStepsPart2'])->uriFor('sendstep32', array('registerOrganisationProgress'=>$registerOrganisationProgress, 'hash'=>$randomHash));

				$mailHeadline = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step31_mail_headline', 'HelfenKannJeder');
				$mailContent = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step31_mail_content', 'HelfenKannJeder');
				$mailContent = sprintf($mailContent, $linkToContinue, $registerOrganisationProgress->getUsername());

				$mailRecipients = $this->mailService->send($registerOrganisationProgress->getMail(), $mailHeadline, $mailContent);
				if ($mailRecipients <= 0) {
					$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step31_error_mail_server_connection_failed', 'HelfenKannJeder'));
				}

				$registerOrganisationProgress->setFinisheduntil(32);
				$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);

				$this->redirect('showstep32', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress));
			}
		} else {
			$this->redirect('showstep20', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress));
		}
	}


	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @ignorevalidation $registerOrganisationProgress
	 * @return void
	 */
	public function showstep32Action($registerOrganisationProgress) {
		if ($this->accessControlService->hasLoggedInFrontendUser()) {
			$this->registerHandleLoggedInUser();
		}
		$registerOrganisationProgress->setLaststep(32);

		$this->view->assign('step', 32);
		$this->view->assign('actionSendMethod', 'sendstep32');
		$this->view->assign('headline', 'register_step32_headline');
		$this->view->assign('objectEditName', 'registerOrganisationProgress');
		$this->view->assign('objectEdit', $registerOrganisationProgress);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array());
	}

	/**
	 * @return void
	 */
	public function initializeSendstep32Action() {
		$this->registerPartialValidatorForArgument('registerOrganisationProgress');
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param string $hash
	 * @ignorevalidation $registerOrganisationProgress
	 * @return void
	 */
	public function sendstep32Action($registerOrganisationProgress, $hash) {
		if ($this->accessControlService->hasLoggedInFrontendUser()) {
			$this->registerHandleLoggedInUser();
		}

		$feUser = $registerOrganisationProgress->getFeuser();

		if ($registerOrganisationProgress->getMailHash() == $hash && $feUser != NULL) {
			$this->accessControlService->setFrontendUserUid($feUser->getUid());
			$registerOrganisationProgress->setMailHash('');
			$registerOrganisationProgress->setFinisheduntil(33);
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);

			$this->redirect('showstep33', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress), $this->settings['registerOrganisationStepsPart2'], 0);
		} else {
			$this->redirect('', NULL, NULL, array(), $this->settings['loggedInMainSite'], 0);
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @ignorevalidation $registerOrganisationProgress
	 * @return void
	 */
	public function showstep33Action($registerOrganisationProgress) {
		$registerOrganisationProgress->setLaststep(33);
		$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);

		$this->view->assign('step', 33);
		$this->view->assign('actionSendMethod', 'sendstep33');
		$this->view->assign('headline', 'register_step33_headline');
		$this->view->assign('objectEditName', 'registerOrganisationProgress');
		$this->view->assign('objectEdit', $registerOrganisationProgress);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array());
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @ignorevalidation $registerOrganisationProgress
	 * @return void
	 */
	public function sendstep33Action($registerOrganisationProgress) {
		if ($registerOrganisationProgress->getFinisheduntil() == 33) {
			$registerOrganisationProgress->setFinisheduntil(40);
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
			$this->redirect('showstep40', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress), $this->settings['registerOrganisationStepsPart3'], 0);
		} else if ($registerOrganisationProgress->getFinisheduntil() > 33) {
			$this->redirect('showstep40', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress), $this->settings['registerOrganisationStepsPart3'], 0);
		} else if ($registerOrganisationProgress->getFinisheduntil() < 33) {
			$this->redirect('showstep10', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress), $this->settings['registerOrganisationStepsPart1'], 0);
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @param array $errorFields
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function showstep40Action($registerOrganisationProgress = NULL, $organisation = NULL, $errorFields = array()) {
		if (!($registerOrganisationProgress instanceof \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress)) {
			$registerOrganisationProgress = $this->registerOrganisationProgress;
		}
		// prove owner of registerOrganisationProgress
		$registerOrganisationProgress->setLaststep(40);

		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
			if ($organisation == NULL) {
				$organisation = new \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft();
				$organisation->setCrdate(time());
				$organisation->setFeuser($registerOrganisationProgress->getFeuser());
				$organisation->setName($registerOrganisationProgress->getOrganisationname());
				$organisation->setOrganisationtype($registerOrganisationProgress->getOrganisationtype());
				$registerOrganisationProgress->setOrganisation($organisation);

				$location = $this->googleMapsService->calculateCityAndDepartment('Germany, '.$registerOrganisationProgress->getCity());
				$supporter = $this->supportService->findSupporter($location, $this->settings['supporterGroup'], $registerOrganisationProgress->getOrganisationtype());
				$organisation->setSupporter($supporter);
				$registerOrganisationProgress->setSupporter($supporter);
				$this->organisationDraftRepository->add($organisation);

				$this->persistenceManager->persistAll();
			}
		}
		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation, FALSE);


		$this->view->assign('step', 40);
		$this->view->assign('actionSendMethod', 'sendstep40');
		$this->view->assign('headline', 'register_step40_headline');
		$this->view->assign('objectEditName', 'organisation');
		$this->view->assign('objectEdit', $organisation);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign('frontendUser', $this->frontendUser);
		$this->view->assign('has_errors', $this->hasErrors());
		$this->view->assign('errorFields', $errorFields);

	}

	/**
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function initializeSendstep40Action() {
		$this->initializeStoreGeneral();
		$this->initializeStoreAddresses();
		$this->initializeStoreEmployees();
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function sendstep40Action($registerOrganisationProgress, $organisation = NULL) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);
		$this->storeGeneral($organisation);
		$this->storeAddresses($organisation);
		$this->storeEmployees($organisation);

		$registerOrganisationProgress->setOrganisation($organisation);

		$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
		$this->persistenceManager->persistAll();

		$this->callValidator('OrganisationInformation', $organisation);
		$this->callValidator('OrganisationAddress', $organisation, '', $registerOrganisationProgress->getCity());
		$this->callValidator('OrganisationEmployee', $organisation);
		$this->callValidator('OrganisationContactperson', $organisation);

		if ($this->stepBack && $this->pageChangeAllowed()) {
			$this->redirect('showstep33', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress), $this->settings['registerOrganisationStepsPart2'], 0);
		} else if ($this->stepSave || !$this->pageChangeAllowed()) {
			$this->redirect('showstep40', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation, 'errorFields' => $this->getErrorFields()));
		} else {
			$this->flashMessageContainer->flush();
			$registerOrganisationProgress->setFinisheduntil(50);
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
			$this->redirect('showstep50', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @param array $errorFields
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function showstep50Action($registerOrganisationProgress, $organisation = NULL, $errorFields = array()) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$registerOrganisationProgress->setLaststep(50);

		$groupListByTemplate = $this->groupDraftRepository->findByOrganisationGroupListByTemplate($organisation);

		$this->view->assign('step', 50);
		$this->view->assign('groups', $groupListByTemplate);
		$this->view->assign('groupsCount', count($groupListByTemplate));
		$this->view->assign('actionSendMethod', 'sendstep50');
		$this->view->assign('headline', 'register_step50_headline');
		$this->view->assign('objectEditName', 'organisation');
		$this->view->assign('objectEdit', $organisation);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign('frontendUser', $this->frontendUser);
		$this->view->assign('has_errors', $this->hasErrors());
		$this->view->assign('errorFields', $errorFields);
	}

	/**
	 * @return void
	 */
	public function initializeSendstep50Action() {
		$this->initializeStoreGroups();
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function sendstep50Action($registerOrganisationProgress, $organisation = NULL) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$this->storeGroups($organisation);
		$this->persistenceManager->persistAll();

		$this->callValidator('OrganisationGroup', $organisation);

		if ($this->stepBack && $this->pageChangeAllowed()) {
			$this->redirect('showstep40', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		} else if ($this->stepSave || !$this->pageChangeAllowed()) {
			$this->redirect('showstep50', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation, 'errorFields' => $this->getErrorFields()));
		} else {
			$this->flashMessageContainer->flush();
			$registerOrganisationProgress->setFinisheduntil(60);
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
			$this->redirect('showstep60', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @param array $errorFields
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function showstep60Action($registerOrganisationProgress, $organisation = NULL, $errorFields = array()) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$registerOrganisationProgress->setLaststep(60);


		$this->view->assign('step', 60);
		$this->view->assign('actionSendMethod', 'sendstep60');
		$this->view->assign('headline', 'register_step60_headline');
		$this->view->assign('objectEditName', 'organisation');
		$this->view->assign('objectEdit', $organisation);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign('frontendUser', $this->frontendUser);
		$this->view->assign('has_errors', $this->hasErrors());
		$this->view->assign('errorFields', $errorFields);
	}

	/**
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function initializeSendstep60Action() {
		$this->initializeStoreWorkinghours();
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function sendstep60Action($registerOrganisationProgress, $organisation = NULL) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$this->storeWorkinghours($organisation);

		$this->callValidator('OrganisationWorkinghour', $organisation);

		if ($this->stepBack && $this->pageChangeAllowed()) {
			$this->redirect('showstep50', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		} else if ($this->stepSave || !$this->pageChangeAllowed()) {
			$this->redirect('showstep60', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation, 'errorFields' => $this->getErrorFields()));
		} else {
			$this->flashMessageContainer->flush();
			$registerOrganisationProgress->setFinisheduntil(70);
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
			$this->redirect('showstep70', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function showstep70Action($registerOrganisationProgress, $organisation = NULL) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$organisation->setHash($this->accessControlService->getSessionId());
		$this->organisationDraftRepository->update($organisation);
		$registerOrganisationProgress->setLaststep(70);
		$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);

		$this->view->assign('step', 70);
		$this->view->assign('actionSendMethod', 'sendstep70');
		$this->view->assign('headline', 'register_step70_headline');
		$this->view->assign('objectEditName', 'organisation');
		$this->view->assign('objectEdit', $organisation);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign('frontendUser', $this->frontendUser);
		$this->view->assign('has_errors', $this->hasErrors());
		$this->view->assign('sessionid', $this->accessControlService->getSessionId());
		$this->view->assign('imageFolder', $this->imageFolder);
		$this->view->assign('internetexplorer', $this->getBrowser() == 'ie');
		$this->view->assign('uploadPageUid', $this->settings['registerOrganisationStepsPart2']);
	}

	/**
	 * @return void
	 */
	public function initializeSendstep70Action() {
		$this->initializeStorePictures();
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function sendstep70Action($registerOrganisationProgress, $organisation = NULL) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$this->storePictures($organisation);

		$this->callValidator('OrganisationPicture', $organisation, '', $this->imageFolder);

		if ($this->stepBack && $this->pageChangeAllowed()) {
			$this->redirect('showstep60', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		} else if ($this->stepSave || !$this->pageChangeAllowed()) {
			$this->redirect('showstep70', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		} else {
			$this->flashMessageContainer->flush();
			$registerOrganisationProgress->setFinisheduntil(80);
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
			$this->redirect('showstep80', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function showstep71Action($registerOrganisationProgress = NULL, $organisation = NULL) {
		if ($registerOrganisationProgress == NULL) {
			$registerOrganisationProgress = $this->registerOrganisationProgress;
		}

		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();

		}
		$registerOrganisationProgress->setLaststep(71);

		$this->view->assign('step', 71);
		$this->view->assign('actionSendMethod', 'sendstep71');
		$this->view->assign('headline', 'register_step71_headline');
		$this->view->assign('objectEditName', 'organisation');
		$this->view->assign('objectEdit', $organisation);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign('frontendUser', $this->frontendUser);
		$this->view->assign('imageFolder', $this->imageFolder);
		$this->view->assign('has_errors', $this->hasErrors());
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function sendstep71Action($registerOrganisationProgress, $organisation = NULL) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$this->organisationDraftRepository->update($organisation);

		$this->callValidator('OrganisationPicture', $organisation, '', $this->imageFolder);

		if ($this->stepBack && $this->pageChangeAllowed()) {
			$this->redirect('showstep70', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		} else if ($this->stepSave || !$this->pageChangeAllowed()) {
			$this->redirect('showstep71', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		} else {
			$this->flashMessageContainer->flush();
			$registerOrganisationProgress->setFinisheduntil(80);
			$this->registerOrganisationProgressRepository->update($registerOrganisationProgress);
			$this->redirect('showstep80', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function showstep80Action($registerOrganisationProgress, $organisation = NULL) {
		if ($organisation == NULL) {
			$organisation = $registerOrganisationProgress->getOrganisation();
		}

		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		$registerOrganisationProgress->setLaststep(80);

		$this->persistenceManager->persistAll();
		$this->callValidator('OrganisationInformation', $organisation);
		$this->callValidator('OrganisationAddress', $organisation, '', $registerOrganisationProgress->getCity());
		$this->callValidator('OrganisationEmployee', $organisation);
		$this->callValidator('OrganisationContactperson', $organisation);
		$this->callValidator('OrganisationGroup', $organisation);
		$this->callValidator('OrganisationWorkinghour', $organisation);
		$this->callValidator('OrganisationPicture', $organisation, '', $this->imageFolder);

		$this->view->assign('step', 80);
		$this->view->assign('actionSendMethod', 'sendstep80');
		$this->view->assign('headline', 'register_step80_headline');
		$this->view->assign('objectEditName', 'organisation');
		$this->view->assign('objectEdit', $organisation);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign('frontendUser', $this->frontendUser);
		$this->view->assign('imageFolder', $this->imageFolder);
		$this->view->assign('employees', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisation->getUid()));
		$this->view->assign('groups', $this->groupDraftRepository->findByOrganisationUid($organisation->getUid()));
		$this->view->assign('has_errors', $this->hasErrors());
		$this->view->assign('editLink', array(
			'general' => 'showstep40',
			'picture' => 'showstep70',
			'matrix' => 'showstep81',
			'workinghour' => 'showstep60',
			'group' => 'showstep50',
		));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function sendstep80Action($registerOrganisationProgress = NULL, $organisation = NULL) {
		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

		if ($this->stepBack) {
			$this->redirect('showstep71', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
		} else {
			$this->callValidator('OrganisationInformation', $organisation);
			$this->callValidator('OrganisationAddress', $organisation, '', $registerOrganisationProgress->getCity());
			$this->callValidator('OrganisationEmployee', $organisation);
			$this->callValidator('OrganisationContactperson', $organisation);
			$this->callValidator('OrganisationGroup', $organisation);
			$this->callValidator('OrganisationWorkinghour', $organisation);
			$this->callValidator('OrganisationPicture', $organisation, '', $this->imageFolder);

			if ($this->hasErrors()) {
				$this->redirect('showstep80', NULL, NULL, array('registerOrganisationProgress' => $registerOrganisationProgress, 'organisation' => $organisation));
			} else {
				$groupExists = FALSE;
				foreach ( $this->frontendUser->getUsergroup() as $group) {
					if ($group->getUid() == $this->settings['registerProgressUserGroup']) {
						$this->frontendUser->removeUsergroup($group);
					}
					if ($group->getUid() == $this->settings['registeredUserGroup']) {
						$groupExists = TRUE;
					}
				}

				if (!$groupExists) {
					$this->frontendUser->addUsergroup($this->frontendUserGroupRepository->findByUid($this->settings['registeredUserGroup']));
				}
				$logger = $this->logManager->getLogger(__CLASS__);
				$logger->info('User requested confirmation after self registration.', array($organisation));
				$organisation->setRequest(1);
				$organisation->setRequesttime(time());
				$this->organisationDraftRepository->update($organisation);

				$mailHeadline = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step80_mail_headline', 'HelfenKannJeder');
				$mailContent = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('register_step80_mail_content', 'HelfenKannJeder');
				$this->mailService->send($registerOrganisationProgress->getMail(), $mailHeadline, $mailContent);
				// TODO mail an supporter
				$supporter = $organisation->getSupporter();
				if ($supporter instanceof \Querformatik\HelfenKannJeder\Domain\Model\Supporter && $supporter->getEmail() != '') {
					$mailHeadline = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.supporter.afterRequest.headline', 'HelfenKannJeder'), $organisation->getName());
					$mailContent = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.supporter.afterRequest.content', 'HelfenKannJeder'), $supporter->getFirstName(), $organisation->getName());
					$this->mailService->send($supporter->getEmail(), $mailHeadline, $mailContent);
				}

				$this->redirect('showstep90', NULL, NULL, array(), $this->settings['registerOrganisationStepsPart2'], 0);
			}
		}
	}


	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\RegisterOrganisationProgress $registerOrganisationProgress
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisation
	 * @ignorevalidation $registerOrganisationProgress
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function showstep81Action($registerOrganisationProgress = NULL, $organisation = NULL) {
		$this->registerHandleProveAccess($registerOrganisationProgress, $organisation);

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
		$this->view->assign('step', 81);
		$this->view->assign('actionSendMethod', 'showstep80');
		$this->view->assign('headline', 'register_step81_headline');
		$this->view->assign('objectEditName', 'organisation');
		$this->view->assign('objectEdit', $organisation);
		$this->view->assign('registerOrganisationProgress', $registerOrganisationProgress);
		$this->view->assign('args', array('registerOrganisationProgress' => $registerOrganisationProgress));
		$this->view->assign('frontendUser', $this->frontendUser);
		$this->view->assign('imageFolder', $this->imageFolder);
		$this->view->assign('employees', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisation->getUid()));
		$this->view->assign('groups', $this->groupDraftRepository->findByOrganisationUid($organisation->getUid()));
	}

	/**
	 * @return void
	 */
	public function showstep90Action() {
		$this->view->assign('continuePageId', $this->settings['loggedInMainSite']);
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 * @param string $hash
	 * @return void
	 */
	public function doNotRemindMeAction($organisationDraft, $hash) {
		$organisationDraft = $this->organisationDraftRepository->findByUid($organisationDraft->getUid());
		if ($organisationDraft->getControlHash() == $hash) {
			$organisationDraft->setRemindCount(-1);
			$this->organisationDraftRepository->update($organisationDraft);
			$logger = $this->logManager->getLogger(__CLASS__);
			$logger->info('The organisation want no more remind mails.', array($organisationDraft));
			$this->view->assign('noRemind', TRUE);
		} else {
			$this->view->assign('noRemind', FALSE);
		}
	}
}
