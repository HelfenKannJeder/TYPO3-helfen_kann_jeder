<?php
namespace Querformatik\HelfenKannJeder\Tests\Unit;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test for SupportService for finding the corrospondending user
 *
 * @author Valentin Zickner
 */
class SupportServiceTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\SupportService
	 */
	protected $supportService;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->supportService = GeneralUtility::makeInstance('Querformatik\\HelfenKannJeder\\Service\\SupportService');
	}

	/**
	 * Test the phone number normalization
	 *
	 * @test
	 * @return void
	 */
	public function testFindSupporter() {
//		$mockRepository = $this->getMock('\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository');
//		$mockQuery = $this->getMock('TYPO3\CMS\Extbase\Persistence\QueryInterface');
//		$mockRepository->expects($this->once())->method('findAll')->will($this->returnValue($mockQuery));
//		$this->inject($this->supportService, 'frontendUserGroupRepository', $mockRepository);
//
//		$this->supportService->findSupporter($location, $supporterGroupId, $organisationtype = NULL);
	}
}
