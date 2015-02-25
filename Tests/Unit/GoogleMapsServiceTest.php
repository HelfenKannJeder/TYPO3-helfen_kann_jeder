<?php
namespace Querformatik\HelfenKannJeder\Tests\Unit;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Fractional test for support controller, see also
 * http://wiki.typo3.org/Functional_testing
 *
 * @author Valentin Zickner
 */
class GoogleMapsServiceTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\GoogleMapsService
	 */
	protected $googleMapsService;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->googleMapsService = GeneralUtility::makeInstance('Querformatik\\HelfenKannJeder\\Service\\GoogleMapsService');
	}

	/**
	 * Test the approx distance method.
	 *
	 * @test
	 * @return void
	 */
	public function testApproxDistance() {
		$distance = $this->googleMapsService->approxDistance(49.008083, 8.403756, 48.777107, 9.180769);
		$this->assertSame(62.341, $distance);

		$distance = $this->googleMapsService->approxDistance(52.372066, 9.735686, 49.008083, 8.403756);
		$this->assertSame(385.627, $distance);
	}
}
