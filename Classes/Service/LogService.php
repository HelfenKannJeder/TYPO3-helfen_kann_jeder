<?php
namespace Querformatik\HelfenKannJeder\Service;

class LogService implements \TYPO3\CMS\Core\SingletonInterface {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\LogRepository
	 * @inject
	 */
	protected $logRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\AccessControlService
	 * @inject
	 */
	protected $accessControlService;

	public function insert($message, $organisation = null) {
		$newLogEntry = new \Querformatik\HelfenKannJeder\Domain\Model\Log();
		$newLogEntry->setMessage($message);
		$newLogEntry->setFeuser($this->accessControlService->getFrontendUser());
		$newLogEntry->setOrganisation($organisation);
		$this->logRepository->add($newLogEntry);
	}
}
?>
