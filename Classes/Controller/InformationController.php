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
namespace Querformatik\HelfenKannJeder\Controller;

/**
 * Displays information for organisations or other users.
 *
 * @author Valentin Zickner
 */
class InformationController extends AbstractOrganisationController {

	/**
	 * organisationDraftRepository
	 *
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 * @inject
	 */
	protected $draftRepository;

	/**
	 * accessControlService
	 *
	 * @var \Querformatik\HelfenKannJeder\Service\AccessControlService
	 * @inject
	 */
	protected $accessControlService;

	/**
	 * Get the first supporter for the current, logged in, organisation
	 *
	 * @return void
	 */
	public function organisationAction() {
		$frontendUser = $this->accessControlService->getFrontendUser();
		if ($frontendUser != NULL) {
			$organisation = $this->draftRepository->findByFeuser($frontendUser->getUid())->getFirst();
		}
		$this->view->assign('organisation', $organisation);
	}

	/**
	 * Get information about currently logged in user
	 *
	 * @return void
	 */
	public function loggedInAction() {
		$frontendUser = $this->accessControlService->getFrontendUser();
		$this->view->assign('frontendUser', $frontendUser);
	}


	/**
	 * Get information about user location
	 *
	 * @return void
	 */
	public function mapAction() {
	}

}
