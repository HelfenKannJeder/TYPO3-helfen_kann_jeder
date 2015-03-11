<?php
namespace Querformatik\HelfenKannJeder\Service;

/**
 * This class is for control the communication from qu_messaging with other
 * users.
 *
 * @author Valentin Zickner
 */
class UserCommunicationService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 * @inject
	 */
	protected $draftRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\AccessControlService
	 * @inject
	 */
	protected $accessControlService;

	/**
	 * @return string String of allowed contacts to communicate with.
	 */
	public function getAllowedContacts() {
		$allowedContacts = array();
		$frontendUser = $this->accessControlService->getFrontendUser();

		if ($frontendUser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
			$organisations = $this->draftRepository->findByFeuser($frontendUser->getUid());
			foreach ($organisations as $organisation) {
				$supporter = $organisation->getSupporter();
				if ($supporter instanceof \Querformatik\HelfenKannJeder\Domain\Model\Supporter) {
					$allowedContacts[] = $supporter->getUid();
				}
			}
		} else {
			$frontendSupporter = $this->accessControlService->getFrontendSupporter();
			$organisations = $this->draftRepository->findBySupporterAndRequest($frontendSupporter);
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

		return implode(',', $allowedContacts);
	}
}
