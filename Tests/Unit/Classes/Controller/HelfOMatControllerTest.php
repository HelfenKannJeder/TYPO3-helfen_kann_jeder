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
				'default' => 42
			)
		);
		$this->controller->_set('settings', $this->settings);

		$this->helfomatRepository = $this->getMock('\Querformatik\HelfenKannJeder\Domain\Model\HelfOMat', array('findByUid'));

		$this->inject($this->controller, 'helfomatRepository', $this->helfomatRepository);
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
}
