<?php
namespace Querformatik\HelfenKannJeder\Service;

class UserCommunicationService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	public function getAllowedContacts() {
		$organisationDraftRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationDraftRepository');
		$accessControlService = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Service\\AccessControlService');

		$allowedContacts = array();
		$frontendUser = $accessControlService->getFrontendUser();

		if ($frontendUser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
			$organisations = $organisationDraftRepository->findByFeuser($frontendUser->getUid());
			foreach ($organisations as $organisation) {
				$supporter = $organisation->getSupporter();
				if ($supporter instanceof \Querformatik\HelfenKannJeder\Domain\Model\Supporter) {
					$allowedContacts[] = $supporter->getUid();
				}
			}
		} else {
			$frontendSupporter = $accessControlService->getFrontendSupporter();
			$organisations = $organisationDraftRepository->findBySupporterAndRequest($frontendSupporter);
			foreach ($organisations as $organisation) {
				$feUser = $organisation->getFeuser();
				if ($feUser instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
					$feUser = $feUser->_loadRealInstance();
				}
				if ($feUser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
					$allowedContacts[] = $feUser->getUid();
				}
			}
		}

		return implode(",", $allowedContacts);
		
	}
}
?>
