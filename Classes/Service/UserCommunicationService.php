<?php
class Tx_HelfenKannJeder_Service_UserCommunicationService implements t3lib_Singleton {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	public function getAllowedContacts() {
		$organisationDraftRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationDraftRepository');
		$accessControlService = $this->objectManager->get('Tx_HelfenKannJeder_Service_AccessControlService');

		$allowedContacts = array();
		$frontendUser = $accessControlService->getFrontendUser();

		if ($frontendUser instanceof Tx_Extbase_Domain_Model_FrontendUser) {
			$organisations = $organisationDraftRepository->findByFeuser($frontendUser->getUid());
			foreach ($organisations as $organisation) {
				$supporter = $organisation->getSupporter();
				if ($supporter instanceof Tx_HelfenKannJeder_Domain_Model_Supporter) {
					$allowedContacts[] = $supporter->getUid();
				}
			}
		} else {
			$frontendSupporter = $accessControlService->getFrontendSupporter();
			$organisations = $organisationDraftRepository->findBySupporterAndRequest($frontendSupporter);
			foreach ($organisations as $organisation) {
				$feUser = $organisation->getFeuser();
				if ($feUser instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
					$feUser = $feUser->_loadRealInstance();
				}
				if ($feUser instanceof Tx_Extbase_Domain_Model_FrontendUser) {
					$allowedContacts[] = $feUser->getUid();
				}
			}
		}

		return implode(",", $allowedContacts);
		
	}
}
?>
