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
namespace Querformatik\HelfenKannJeder\Command;

/**
 * Remind controller
 */
class RemindCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @var \Tx_QuBase_Service_MailService
	 * @inject
	 */
	protected $mailService;

	/**
	 * Log manager to log it when mail sending failed.
	 *
	 * @var TYPO3\CMS\Core\Log\LogManager
	 * @inject
	 */
	protected $logManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 * @inject
	 */
	protected $organisationDraftRepository;

	protected $settings;

	/**
	 * @param integer $storagePid Id where to read the data from
	 * @param string $administratorMail Mail of the administrator to use as bcc.
	 * @internal
	 */
	private function initCommand($storagePid, $administratorMail = null) {
		$frameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$persistenceConfiguration = array(
			'persistence' => array(
				'storagePid' => $storagePid,
				'classes' => array(
					'Querformatik\\HelfenKannJeder\\Domain\\Model\\Supporter' => array(
						'mapping' => array(
							'tableName' => 'fe_users',
							'recordType' => 'Querformatik\\HelfenKannJeder\\Domain\\Model\\Supporter',
						)
					)
				)
			),
		);
		$this->configurationManager->setConfiguration(array_merge($frameworkConfiguration, $persistenceConfiguration));

		$this->settings = $this->configurationManager->getConfiguration( \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'HelfenKannJeder', 'List');

		$this->mailService->setFrom($this->settings["mailFrom"]);

		if ($administratorMail != null) {
			$this->mailService->setAdditionalHeader("Bcc: ".$administratorMail);
		}
	}

	/**
	 * Send reminder to supporters
	 *
	 * @param integer $storagePid Id where to read the data from
	 * @param string $administratorMail Mail of the administrator to use as bcc.
	 * @return void
	 */
	public function supporterCommand($storagePid, $administratorMail = null) {
		$this->initCommand($storagePid, $administratorMail);

		$periodDays = 2;
		$minDays = 2;
		$additionalCCDays = 365;
		$additionalCCAddress = "root@localhost";
		$defaultMailAddress = $this->settings["mailAdmin"];

		if (isset($this->settings["mail"]["reminder"]["supporter"]["minDays"])) {
			$minDays = $this->settings["mail"]["reminder"]["supporter"]["minDays"];
		}

		if (isset($this->settings["mail"]["reminder"]["supporter"]["periodDays"])) {
			$periodDays = $this->settings["mail"]["reminder"]["supporter"]["periodDays"];
		}

		if (isset($this->settings["mail"]["reminder"]["supporter"]["additionalCCDays"])) {
			$additionalCCDays = $this->settings["mail"]["reminder"]["supporter"]["additionalCCDays"];
		}

		if (isset($this->settings["mail"]["reminder"]["supporter"]["additionalCCAddress"])) {
			$additionalCCAddress = $this->settings["mail"]["reminder"]["supporter"]["additionalCCAddress"];
		}


		$waitingOrganisations = $this->organisationDraftRepository->findByRequest(1);
		foreach ($waitingOrganisations as $organisation) {
			$waitingDays = (time()-$organisation->getRequesttime())/86400;
			if ($waitingDays >= $minDays && $waitingDays%$periodDays == 0) {
				$mailHeadline = $this->settings["mail"]["reminder"]["supporter"]["subject"];
				$mailContent  = $this->settings["mail"]["reminder"]["supporter"]["content"];

				$mail = $defaultMailAddress;
				if ($organisation->getSupporter() != null) {
					$mail = $organisation->getSupporter()->getEmail();
					$mailContent = str_replace("%name%", $organisation->getSupporter()->getFirstname(), $mailContent);
				}
				$mailContent = str_replace("%organisation%", $organisation->getName(), $mailContent);

				$cc = array();
				if ($waitingDays >= $additionalCCDays) {
					$cc[] = $additionalCCAddress;
				}
				$this->mailService->send($mail, $mailHeadline, $mailContent, $cc);

				$logger = $this->logManager->getLogger(__CLASS__);
				$logger->info('Reminded supporter to activate organisation', array($organisation));
			}
		}
	}

	/**
	 * Remind users to complete their registration.
	 *
	 * @param integer $storagePid Id where to read the data from
	 * @param string $administratorMail Mail of the administrator to use as bcc.
	 * @return void
	 */
	public function userForCompleteRegistrationCommand($storagePid, $administratorMail = null) {
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
			$logger = $this->logManager->getLogger(__CLASS__);
			$logger->info('Reminded organisation to complete registration', array($organisationDraft));
		}
		if (empty($sendTo)) $sendTo = "Nobody!";
		$this->view->assign("sendTo", $sendTo);
	}
}
?>
