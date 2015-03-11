<?php
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
		return $this->searchService->findOrganisations($persLat, $persLng, $answer,
			$this->settings['config']['maxDistance'], array(&$this, 'buildOrganisationUri'));
	}

	public function buildOrganisationUri($uid) {
		return $this->uriBuilder->reset()->setTargetPageUid($this->settings['page']['overview']['detail'])
			->uriFor('detail', array('organisation' => $uid), 'Overview');
	}
}
