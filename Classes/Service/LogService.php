<?php
namespace Querformatik\HelfenKannJeder\Service;

class LogService implements \TYPO3\CMS\Core\SingletonInterface {
	protected $logRepository;
	protected $accessControlService;

	public function __construct() {
		$this->logRepository = t3lib_div::makeInstance('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\LogRepository');
		$this->accessControlService = t3lib_div::makeInstance('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService');
	}

	public function insert($message, $organisation = null) {
		$newLogEntry = new \Querformatik\HelfenKannJeder\Domain\Model\Log();
		$newLogEntry->setMessage($message);
		$newLogEntry->setFeuser($this->accessControlService->getFrontendUser());
		$newLogEntry->setOrganisation($organisation);
		$this->logRepository->add($newLogEntry);
	}
}
?>
