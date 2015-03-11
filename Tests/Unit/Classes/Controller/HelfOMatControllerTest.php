<?php
namespace Querformatik\HelfenKannJeder\Tests\Unit;

use Querformatik\HelfenKannJeder\Domain\Model\HelfOMat;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Unit test for google maps service
 *
 * @author Valentin Zickner
 */
class HelfOMatControllerTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Controller\HelfOMatController
	 */
	protected $controller;

	protected $settings;

	protected $request;

	protected $view;

	/**
	 */
	protected $helfomatRepository;

	/**
	 *
	 */
	protected $cookieService;

	/**
	 *
	 */
	protected $searchService;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->controller = $this->getAccessibleMock('\\Querformatik\\HelfenKannJeder\\Controller\\HelfOMatController',
			array('dummy'));
		$this->prepareController();
	}

	/**
	 * @return void
	 */
	protected function prepareController() {
		$this->request = $this->getMock('\\TYPO3\\CMS\\Extbase\\Mvc\\Request');
		$this->controller->_set('request', $this->request);

		$this->view = $this->getMock('\\TYPO3\\CMS\\Fluid\\View\\TemplateView', array('assign'), array(), '', FALSE);
		$this->controller->_set('view', $this->view);

		$this->settings = array(
			'helfomat' => array(
				'default' => 42,
			),
			'config' => array(
				'maxDistance' => 100,
			),
			'page' => array(
				'overview' => array(
					'detail' => 1337,
				),
			),
		);
		$this->controller->_set('settings', $this->settings);

		$this->helfomatRepository = $this->getMock('\Querformatik\HelfenKannJeder\Domain\Model\HelfOMat', array('findByUid'));
		$this->inject($this->controller, 'helfomatRepository', $this->helfomatRepository);

		$this->cookieService = $this->getMock('\Querformatik\HelfenKannJeder\Service\CookieService', array('getPersonalCookie'));
		$this->inject($this->controller, 'cookieService', $this->cookieService);

		$this->searchService = $this->getMock('\Querformatik\HelfenKannJeder\Service\OrganisationSearchService',
			array('findOrganisations'));
		$this->inject($this->controller, 'searchService', $this->searchService);
	}

	/**
	 * @test
	 * @return void
	 */
	public function testQuizActionDefault() {
		$helfomat = new HelfOMat();
		$this->helfomatRepository
			->expects($this->once())
			->method('findByUid')
			->with($this->identicalTo(42))
			->will($this->returnValue($helfomat));
		$this->view
			->expects($this->once())
			->method('assign')
			->with(
				$this->identicalTo('helfOMat'),
				$this->identicalTo($helfomat)
			);
		$this->controller->quizAction(NULL);
	}

	/**
	 * @test
	 * @return void
	 */
	public function testQuizActionParameter() {
		$helfomat = new HelfOMat();
		$this->helfomatRepository
			->expects($this->never())
			->method('findByUid');
		$this->view
			->expects($this->once())
			->method('assign')
			->with(
				$this->identicalTo('helfOMat'),
				$this->identicalTo($helfomat)
			);
		$this->controller->quizAction($helfomat);
	}

	/**
	 * @test
	 * @return void
	 */
	public function testGroupResultAction() {
		$helfomat = new HelfOMat();
		$answer = array(
			10 => 1,
			11 => 2,
			12 => 0,
			9 => 2,
			15 => 0
		);
		$organisations = array(
			10 => array(
				'something special'
			)
		);
		$this->view
			->expects($this->at(0))
			->method('assign')
			->with(
				$this->identicalTo('answer'),
				$this->identicalTo($answer)
			);
		$this->view
			->expects($this->at(1))
			->method('assign')
			->with(
				$this->identicalTo('helfOMat'),
				$this->identicalTo($helfomat)
			);
		$this->view
			->expects($this->at(2))
			->method('assign')
			->with(
				$this->identicalTo('normGradeToMax'),
				$this->identicalTo(1 / 100)
			);
		$this->view
			->expects($this->at(3))
			->method('assign')
			->with(
				$this->identicalTo('organisations'),
				$this->identicalTo($organisations)
			);

		$this->pTestCalculateGroupResult($answer, $organisations);

		$this->controller->groupResultAction($helfomat, $answer);
	}

	/**
	 * @test
	 * @return void
	 */
	public function testJsonGroupResultAction() {
		$answer = array(
			10 => 1,
			11 => 2,
			12 => 0,
			9 => 2,
			15 => 0
		);
		$organisations = array(
			10 => array(
				'something special'
			)
		);
		$this->pTestCalculateGroupResult($answer, $organisations);

		$result = $this->controller->jsonGroupResultAction($answer);
		$this->assertEquals('{"10":["something special"]}', $result);
	}

	/**
	 * @test
	 * @return void
	 */
	public function testBuildOrganisationUri() {
		// TODO: Build this test
		$this->assertTrue(TRUE);
	}

	/**
	 * @return void
	 */
	private function pTestCalculateGroupResult($answer, $organisations) {
		$this->cookieService
			->expects($this->any())
			->method('getPersonalCookie')
			->will($this->returnValue(array(49.1234, 8.2313, 18)));

		$this->searchService
			->expects($this->once())
			->method('findOrganisations')
			->with(
				49.1234, 8.2313, $answer, 100, array(&$this->controller, 'buildOrganisationUri')
			)
			->will($this->returnValue($organisations));
	}
}
