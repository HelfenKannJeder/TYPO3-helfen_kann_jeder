<?php
namespace Querformatik\HelfenKannJeder\Tests\Unit;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Unit test for normalization service
 *
 * @author Valentin Zickner
 */
class NormServiceTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\NormService
	 */
	protected $normService;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->normService = GeneralUtility::makeInstance('Querformatik\\HelfenKannJeder\\Service\\NormService');
	}

	/**
	 * Test the phone number normalization
	 *
	 * @test
	 * @return void
	 */
	public function testPhoneNumber() {
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('+49721 / 123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('+49721 123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('+49721123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('+49721 123 45 67 89'));

		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0049721 / 123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0049721 123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0049721123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0049721 123 45 67 89'));

		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0721 / 123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0721 123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0721123456789'));
		$this->assertSame('0721 123456789', $this->normService->phoneNumber('0721 123 45 67 89'));

		$this->assertSame('07031 4970042', $this->normService->phoneNumber('07031 / 4970042'));
		$this->assertSame('07031 4970042', $this->normService->phoneNumber('07031 4970042'));
		$this->assertSame('07031 4970042', $this->normService->phoneNumber('070314970042'));
		$this->assertSame('07031 4970042', $this->normService->phoneNumber('0 70 31 497 00 42'));
	}
}
