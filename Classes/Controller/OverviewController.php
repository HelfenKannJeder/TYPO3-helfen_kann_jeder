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
 * Overview over organisations in the near of the user or all dummy
 * organisations.
 *
 * @author Valentin Zickner
 */
class OverviewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationRepository
	 * @inject
	 */
	protected $organisationRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\EmployeeRepository
	 * @inject
	 */
	protected $employeeRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\GroupRepository
	 * @inject
	 */
	protected $groupRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\CookieService
	 * @inject
	 */
	protected $cookieService;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\GoogleMapsService
	 * @inject
	 */
	protected $googleMapsService;

	/**
	 * @return void
	 */
	public function indexAction() {
		list($latitude, $longitude) = $this->cookieService->getPersonalCookie();

		if ($latitude == 0 || $longitude == 0) {
			$organisations = $this->organisationRepository->findByIsDummy(1);
		} else {
			$organisations = $this->organisationRepository->findOrganisationNearLocation($latitude, $longitude, FALSE)->toArray();
			$organisations = $this->googleMapsService->filterByDistance($organisations, $latitude, $longitude,
				$this->settings['config']['maxDistance']);
			$organisations = $this->googleMapsService->sortByDistance($organisations, $latitude, $longitude);
		}
		$this->view->assign('organisations', $organisations);
		$this->view->assign('latitude', $latitude);
		$this->view->assign('longitude', $longitude);
	}

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation
	 * @ignorevalidation $organisation
	 * @return void
	 */
	public function detailAction(\Querformatik\HelfenKannJeder\Domain\Model\Organisation $organisation) {
		$this->view->assign('organisation', $organisation);
		$this->view->assign('employees', $this->employeeRepository->findByOrganisationUidWithStatement($organisation->getUid()));
		$this->view->assign('groups', $this->groupRepository->findByOrganisationUid($organisation->getUid()));
	}
}
