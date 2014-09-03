<?php
class Tx_HelfenKannJeder_Service_LogService implements t3lib_Singleton {
	protected $logRepository;
	protected $accessControlService;

	public function __construct() {
		$this->logRepository = t3lib_div::makeInstance('Tx_HelfenKannJeder_Domain_Repository_LogRepository');
		$this->accessControlService = t3lib_div::makeInstance('Tx_HelfenKannJeder_Service_AccessControlService');
	}

	public function insert($message, $organisation = null) {
		$newLogEntry = new Tx_HelfenKannJeder_Domain_Model_Log();
		$newLogEntry->setMessage($message);
		$newLogEntry->setFeuser($this->accessControlService->getFrontendUser());
		$newLogEntry->setOrganisation($organisation);
		$this->logRepository->add($newLogEntry);
	}
}
?>
