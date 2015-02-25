<?php
namespace Querformatik\HelfenKannJeder\Controller;

class UserSettingsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	protected $accessControlService;
	protected $frontendUserRepository;
	protected $frontendUser;

	/**
	 * Log manager to log it when mail sending failed.
	 *
	 * @var TYPO3\CMS\Core\Log\LogManager
	 * @inject
	 */
	protected $logManager;

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService');
		$this->frontendUserRepository = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
		$this->frontendUser = $this->accessControlService->getFrontendUser();
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
	 * @return void
	 */
	public function editAction($frontendUser = null) {
		if ($frontendUser != null && $frontendUser->getUid() == $this->frontendUser->getUid() &&
			$frontendUser->getUsername() == $this->frontendUser->getUsername()) {
			$this->view->assign("frontendUser", $frontendUser);
		} else {
			$this->view->assign("frontendUser", $this->frontendUser);
		}
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
	 * @return void
	 */
	public function saveAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser) {
		if ($frontendUser->getUid() == $this->frontendUser->getUid() &&
			$frontendUser->getUsername() == $this->frontendUser->getUsername()) {

			$error = false;
			if (strlen($frontendUser->getFirstName()) < 2) {
				$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('usersetting.firstname.toShort', 'HelfenKannJeder'));
				$error = true;
			}
			if (strlen($frontendUser->getLastName()) < 2) {
				$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('usersetting.lastname.toShort', 'HelfenKannJeder'));
				$error = true;
			}
			if (!preg_match("/^[A-Zäöü0-9._%+-]+@[A-Zäöü0-9.-]+\.(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/si",
					$frontendUser->getEmail())) {
				$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error_registerorganisationprogress_invalid_mail', 'HelfenKannJeder').$frontendUser->getEmail());
				$error = true;
			}

			if ($this->request->hasArgument("password1") && $this->request->hasArgument("password2")) {
				$password1 = $this->request->getArgument("password1");
				$password2 = $this->request->getArgument("password2");

				if (strlen($password1) == strlen($password2) && strlen($password2) == 0) {
					// do nothing
				} else if (strlen($password1) < 8) {
					$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('usersetting.password.toShort', 'HelfenKannJeder'));
					$error = true;
				} else if ($password1 != $password2) {
					$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('usersetting.password.notMatch', 'HelfenKannJeder'));
					$error = true;
				} else if (!$error) {
					$logger = $this->logManager->getLogger(__CLASS__);
					$logger->info('User changed the field password.', array($frontendUser));
					$frontendUser->setPassword($password1);
					$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('usersetting.password.changed', 'HelfenKannJeder'));
				}
			}


			if (!$error) {
				$logger = $this->logManager->getLogger(__CLASS__);
				if ($this->frontendUser->getFirstName() != $frontendUser->getFirstName()) {
					$logger->info('User changed first name from ' . $this->frontendUser->getFirstName() . ' to '
						. $frontendUser->getFirstName(), array($frontendUser));
				}
				if ($this->frontendUser->getLastName() != $frontendUser->getLastName()) {
					$logger->info('User changed last name from ' . $this->frontendUser->getLastName() . ' to '
						. $frontendUser->getLastName(), array($frontendUser));
				}
				if ($this->frontendUser->getEmail() != $frontendUser->getEmail()) {
					$logger->info('User changed first mail from ' . $this->frontendUser->getEmail() . ' to '
						. $frontendUser->getEmail(), array($frontendUser));
				}

				$this->frontendUserRepository->update($frontendUser);
				$this->redirect("edit");
			} else {
				$this->forward("edit", null, null, array("frontendUser" => $frontendUser));
			}
		} else {
			$this->redirect("edit");
		}
	}
}
?>
