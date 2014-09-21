<?php
namespace Querformatik\HelfenKannJeder\Controller;

class CronController
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
				// TODO: Dynamic by typoscript settings
	protected $passphrase = "Yhc_vjr5b7h0IXYVSABWV1YLwsPXpo9YrhnlQOlUZpDo30co0E_rNQiZB8A8anJ5";
	protected $mailService;
	protected $logService;
	protected $organisationDraftRepository;

	public function initializeAction() {
		$this->mailService = $this->objectManager->get('\\Tx_QuBase_Service_MailService');
		$this->mailService->setFrom($this->settings["mailFrom"]);
				// TODO: Dynamic by typoscript settings
		$this->mailService->setAdditionalHeader("Bcc: valentin.zickner@helfenkannjeder.de");
		$this->logService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\LogService');

		$this->organisationDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationDraftRepository');
	}

	/**
	 * Execute all cron jobs with this action
	 *
	 * @param string passphrase Passphrase for authentication.
	 */
	public function executeAction($passphrase) {
		if (!$this->provePassphrase($passphrase)) return;

		$this->remindUsersForCompleteRegistrationAction($passphrase);
		$this->reenableScreeningOrganisationAction($passphrase);
	}

	/**
	 * Remind users to complete their registration.
	 *
	 * @param string passphrase Passphrase for authentication.
	 */
	public function remindUsersForCompleteRegistrationAction($passphrase) {
		if (!$this->provePassphrase($passphrase)) return;

		$sendTo = "";
		foreach ($this->organisationDraftRepository->findUncompeletedRegistrations() as $organisationDraft) {
			$feUser = $organisationDraft->getFeuser();
			$sendTo .= $organisationDraft->getName()."\n";

			$mailHeadline = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail_reminder_organisation_register_headline', 'HelfenKannJeder');
			$mailContent = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mail_reminder_organisation_register_content', 'HelfenKannJeder');
			$linkToRemoveFromList = $this->uriBuilder->setTargetPageUid($this->settings["registerOrganisationStepsPart2"])->uriFor("doNotRemindMe", array("organisationDraft"=>$organisationDraft, "hash"=>$organisationDraft->getControlHash()), "Register");
			$mailContent = sprintf($mailContent, $feUser->getFirstName()." ".$feUser->getLastName(), date("d.m.Y", $organisationDraft->getCrDate()), $organisationDraft->getName(), $linkToRemoveFromList);
			$this->mailService->send($feUser->getEmail(), $mailHeadline, $mailContent);
			$organisationDraft->setRemindLast(time());
			$organisationDraft->setRemindCount($organisationDraft->getRemindCount()+1);
			$this->organisationDraftRepository->update($organisationDraft);
			$this->logService->insert("Reminded organisation to complete registration", $organisationDraft);
		}
		if (empty($sendTo)) $sendTo = "Nobody!";
		$this->view->assign("sendTo", $sendTo);
	}

	/**
	 * Prove a given passphrase (mostly from an external script) for equality
	 * with a from the script saved passphrase.
	 *
	 * @param string passphrase Passphrase for authentication.
	 */
	protected function provePassphrase($passphrase) {
		return $passphrase == $this->passphrase;
	}

	/**
	 * Reenable organisation which are screend from an supporter more than an hour,
	 * because screened organisations can not be modified by an user.
	 *
	 * @param string passphrase Passphrase for authentication.
	 */
	public function reenableScreeningOrganisationAction($passphrase) {
		if (!$this->provePassphrase($passphrase)) return;

		$draftOrganisations = $this->organisationDraftRepository->findByRequest(3);
		foreach ($draftOrganisations as $draftOrganisation) {
			if ($draftOrganisation->getRequesttime() < time()-3600) {
				$draftOrganisation->setRequesttime(time());
				$draftOrganisation->setRequest(1);
				$this->organisationDraftRepository->update($draftOrganisation);
				$this->logService->insert("Reenabled organisation for edit by the user", $draftOrganisation);
			}
		}
	}
}
?>
