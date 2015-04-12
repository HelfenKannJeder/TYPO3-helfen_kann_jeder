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
 * "Helfen Kann Jeder" Project
 *
 * @description: This class is the controller of Helf-O-Mat.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2015-03-11
 */
class HelfOMatController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\HelfOMatRepository
	 * @inject
	 */
	protected $helfomatRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\OrganisationSearchService
	 * @inject
	 */
	protected $searchService;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\CookieService
	 * @inject
	 */
	protected $cookieService;

	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat
	 * @return void
	 */
	public function quizAction(\Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat = NULL) {
		if ($helfOMat == NULL && isset($this->settings['helfomat']['default'])) {
			$helfOMat = $this->helfomatRepository->findByUid($this->settings['helfomat']['default']);
		}

		$this->view->assign('helfOMat', $helfOMat);
	}


	/**
	 * @param \Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat
	 * @param array $answer
	 * @return void
	 */
	public function groupResultAction(\Querformatik\HelfenKannJeder\Domain\Model\HelfOMat $helfOMat, $answer) {
		$this->view->assign('answer', $answer);
		$this->view->assign('helfOMat', $helfOMat);
		$this->view->assign('normGradeToMax', 1 / 100);
		$this->view->assign('organisations', $this->calculateGroupResult($answer));
	}


	/**
	 * @param array $answer
	 */
	public function jsonGroupResultAction($answer) {
		$organisations = $this->calculateGroupResult($answer);
		return json_encode($organisations);
	}

	/**
	 * @param array $answer
	 * 		This is from the structure {questionId} => answer, where the questionId
	 * 		is the unique identifier from the question and the answer is an integer
	 * 		between 0 and 2, where
	 * 			0 => neutral
	 * 			1 => yes
	 * 			2 => no
	 * @return array	Array of organisations
	 */
	private function calculateGroupResult($answer) {
		list($persLat, $persLng, $age) = $this->cookieService->getPersonalCookie();

		$questionYes = array_keys($answer, 1);
		$questionNo = array_keys($answer, 2);

		$organisationsVoting = $this->searchService->findOrganisations($persLat, $persLng, $questionYes, $questionNo);
		list($organisations, $gradeMin, $gradeMax) = $this->searchService->createOrganisationObjects($organisationsVoting,
			$persLat, $persLng, $this->settings['config']['maxDistance'], array(&$this, 'buildOrganisationUri'));

		$min = $gradeMin - 10;
		$max = $gradeMax - $min;

		return $this->searchService->normOrganisationGrade($organisations, $min, $max);
	}

	public function buildOrganisationUri($uid) {
		return $this->uriBuilder->reset()->setTargetPageUid($this->settings['page']['overview']['detail'])
			->uriFor('detail', array('organisation' => $uid), 'Overview');
	}
}
