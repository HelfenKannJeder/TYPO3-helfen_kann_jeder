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

/**
 * Support Controller is for Team Members to activate organisations.
 *
 * @author Valentin Zickner
 */
class SupportController
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

	protected $accessControlService;
	protected $frontendUser;
	protected $organisationRepository;
	protected $organisationDraftRepository;
	protected $employeeDraftRepository;
	protected $employeeRepository;
	protected $groupDraftRepository;
	protected $groupRepository;
	protected $mailService;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\DraftToLiveService
	 * @inject
	 */
	protected $draftToLiveService;

	/**
	 * Log manager to log it when mail sending failed.
	 *
	 * @var TYPO3\CMS\Core\Log\LogManager
	 * @inject
	 */
	protected $logManager;

	public function initializeAction() {
		$this->accessControlService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService'); // Singleton
		$this->frontendUser = $this->accessControlService->getFrontendSupporter();
		$this->organisationRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');
		$this->organisationDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationDraftRepository');
		$this->employeeDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeDraftRepository');
		$this->employeeRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\EmployeeRepository');
		$this->groupDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupDraftRepository');
		$this->groupDraftRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		$this->groupRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\GroupRepository');
		$this->groupRepository->setDefaultOrderings(array('name'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		$this->mailService = $this->objectManager->get('\\Tx_QuBase_Service_MailService');
		$this->mailService->setFrom($this->settings["mailFrom"]);
	}

	/**
	 * @return void
	 */
	public function indexAction() {
		$organisationDraftItems = $this->organisationDraftRepository->findBySupporterAndRequest($this->frontendUser);
		$organisationDraftItems = $organisationDraftItems->toArray();
		usort($organisationDraftItems, array(&$this, "sortOrganisationDraftByRequest"));
		$this->view->assign("organisationDrafts", $organisationDraftItems);
	}

	protected function sortOrganisationDraftByRequest($a, $b) {
		$requestList = array(2, 3, 1, 4);
		if ($a->getRequest() == $b->getRequest()) {
			return $a->getRequesttime() > $b->getRequesttime();
		}

		return ($requestList[$a->getRequest()] < $requestList[$b->getRequest()]);
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function test2liveAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		$this->draftToLiveService->draft2live($organisationDraft);
		if ($organisationDraft->getFeuser()->getEmail() != "") {
			$mailHeadline = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestSucceed.headline', 'HelfenKannJeder');
			$mailContent = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestSucceed.content', 'HelfenKannJeder'), $organisationDraft->getFeuser()->getFirstName());
			$this->mailService->send($organisationDraft->getFeuser()->getEmail(), $mailHeadline, $mailContent);
			$this->mailService->send("valentin.zickner@helfenkannjeder.de", $mailHeadline, $mailContent); // TODO: Maybe this should specified in the settings.
		}
		$logger = $this->logManager->getLogger(__CLASS__);
		$logger->info('The organisation was send to live.', array($organisationDraft));
//		$this->cacheApiService->clearPageCache(); // TODO: Is this enouth?: https://github.com/TYPO3-coreapi/ext-coreapi/blob/master/Classes/Service/CacheApiService.php
		$this->redirect("index");
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation
	 */
	public function live2testAction($organisation) {
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function diffAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		if ($organisationDraft->getRequest() == 1 || $organisationDraft->getRequest() == 3) {
			$organisationDraft->setRequest(3);
			$organisationDraft->setRequesttime(time());
			$this->organisationDraftRepository->update($organisationDraft);
			$logger = $this->logManager->getLogger(__CLASS__);
			$logger->info('The organisation was locked by supporter (visit diff).', array($organisationDraft));
		}

		$this->view->assign('organisationDraft', $organisationDraft);
		$this->view->assign('employeesDraft', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisationDraft->getUid()));
		$this->view->assign('groupsDraft', $this->groupDraftRepository->findByOrganisationUid($organisationDraft->getUid()));

		$organisation = $organisationDraft->getReference();
		if ($organisation instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$organisation = $organisation->_loadRealInstance();
		}
		$this->view->assign('organisation', $organisation);
		if ($organisation instanceof \Querformatik\HelfenKannJeder\Domain\Model\Organisation) {
			$this->view->assign('employees', $this->employeeRepository->findByOrganisationUidWithStatement($organisation->getUid()));
			$this->view->assign('groups', $this->groupRepository->findByOrganisationUid($organisation->getUid()));
		}
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function viewAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		if ($organisationDraft->getRequest() == 1 || $organisationDraft->getRequest() == 3) {
			$organisationDraft->setRequest(3);
			$organisationDraft->setRequesttime(time());
			$this->organisationDraftRepository->update($organisationDraft);
			$logger = $this->logManager->getLogger(__CLASS__);
			$logger->info('The organisation was locked by supporter (visit view).', array($organisationDraft));
		}

		$this->view->assign('organisationDraft', $organisationDraft);
		$this->view->assign('employeesDraft', $this->employeeDraftRepository->findByOrganisationUidWithStatement($organisationDraft->getUid()));
		$this->view->assign('groupsDraft', $this->groupDraftRepository->findByOrganisationUid($organisationDraft->getUid()));
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function backAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		$organisationDraft->setRequest(1);
		$organisationDraft->setRequesttime(time());
		$this->organisationDraftRepository->update($organisationDraft);
		$logger = $this->logManager->getLogger(__CLASS__);
		$logger->info('The organisation was unlocked by supporter.', array($organisationDraft));
		$this->redirect("index");
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft $organisationDraft
	 */
	public function denyAction($organisationDraft) {
		if ($organisationDraft->getSupporter() != $this->frontendUser) {
			$this->redirect("index");
			return;
		}

		$organisationDraft->setRequest(0);
		$organisationDraft->setRequesttime(time());
		$this->organisationDraftRepository->update($organisationDraft);

		if ($organisationDraft->getFeuser()->getEmail() != "") {
			$mailHeadline = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestDeny.headline', 'HelfenKannJeder');
			$mailContent = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail.organisation.requestDeny.content', 'HelfenKannJeder'), $organisationDraft->getFeuser()->getFirstName());
			$this->mailService->send($organisationDraft->getFeuser()->getEmail(), $mailHeadline, $mailContent);
		}

		$logger = $this->logManager->getLogger(__CLASS__);
		$logger->info('The organisation was not published by the supporter.', array($organisationDraft));
		$this->redirect("write", "Message", "QuMessaging", array("writeTo" => $organisationDraft->getFeuser()), $this->settings["page"]["messaging"]);
	}
}
