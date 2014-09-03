<?php
/**
 * Remind controller
 */
class Tx_HelfenKannJeder_Command_RemindCommandController extends Tx_Extbase_MVC_Controller_CommandController {

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @var Tx_QuBase_Service_MailService
	 * @inject
	 */
	protected $mailService;

	/**
	 * @var Tx_HelfenKannJeder_Service_LogService
	 * @inject
	 */
	protected $logService;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository
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
		$frameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$persistenceConfiguration = array(
			'persistence' => array(
				'storagePid' => $storagePid,
				'classes' => array(
					'Tx_HelfenKannJeder_Domain_Model_Supporter' => array(
						'mapping' => array(
							'tableName' => 'fe_users',
							'recordType' => 'Tx_HelfenKannJeder_Domain_Model_Supporter',
						)
					)
				)
			),
		);
		$this->configurationManager->setConfiguration(array_merge($frameworkConfiguration, $persistenceConfiguration));

		$this->settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'HelfenKannJeder', 'List');

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

				$this->logService->insert("Reminded supporter to activate organisation", $organisation);
			}
		}
	}
}
?>
