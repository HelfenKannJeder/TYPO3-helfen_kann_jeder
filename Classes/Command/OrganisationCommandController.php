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
class OrganisationCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\GroupRepository
	 * @inject
	 */
	protected $groupRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 * @inject
	 */
	protected $organisationDraftRepository;

	/**
	 * Log manager to log it when mail sending failed.
	 *
	 * @var TYPO3\CMS\Core\Log\LogManager
	 * @inject
	 */
	protected $logManager;

	public function refreshHelfOMatCacheCommand() {
		$this->groupRepository->generateQuestionOrganisationMappingCache();
	}

	/**
	 * Reenable organisation which are screend from an supporter more than an hour,
	 * because screened organisations can not be modified by an user.
	 *
	 * @param integer $storagePid Id where to read the data from
	 * @param string $administratorMail Mail of the administrator to use as bcc.
	 * @return void
	 */
	public function reenableScreeningOrganisationCommand($storagePid, $administratorMail = null) {
		$draftOrganisations = $this->organisationDraftRepository->findByRequest(3);
		foreach ($draftOrganisations as $draftOrganisation) {
			if ($draftOrganisation->getRequesttime() < time()-3600) {
				$draftOrganisation->setRequesttime(time());
				$draftOrganisation->setRequest(1);
				$this->organisationDraftRepository->update($draftOrganisation);

				$logger = $this->logManager->getLogger(__CLASS__);
				$logger->info('Reenabled organisation for edit by the user', array($draftOrganisation));
			}
		}
	}
}
?>
