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
