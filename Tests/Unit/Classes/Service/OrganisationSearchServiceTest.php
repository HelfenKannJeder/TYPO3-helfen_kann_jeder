<?php
namespace Querformatik\HelfenKannJeder\Tests\Unit;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Unit test for organisation search service
 *
 * @author Valentin Zickner
 */
class OrganisationSearchServiceTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\OrganisationSearchService
	 */
	protected $fixture;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationRepository
	 */
	protected $organisationRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\GroupRepository
	 */
	protected $groupRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\GoogleMapsService
	 */
	protected $googleMapsService;

	protected $organisationType;

	protected $organisation1;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->fixture = GeneralUtility::makeInstance('Querformatik\HelfenKannJeder\Tests\Unit\Fixtures\OrganisationSearchService');

		$this->organisationRepository = $this->getMock('Querformatik\HelfenKannJeder\Domain\Repository\OrganisationRepository',
			array(), array(), '', FALSE);
		$this->inject($this->fixture, 'organisationRepository', $this->organisationRepository);

		$this->groupRepository = $this->getMock('Querformatik\HelfenKannJeder\Domain\Repository\GroupRepository',
			array(), array(), '', FALSE);
		$this->inject($this->fixture, 'groupRepository', $this->groupRepository);

		$this->googleMapsService = $this->getMock('\Querformatik\HelfenKannJeder\Service\GoogleMapsService');
		$this->inject($this->fixture, 'googleMapsService', $this->googleMapsService);

		$this->organisationType = $this->getMock('Querformatik\HelfenKannJeder\Domain\Model\OrganisationType');

		$this->organisation1 = $this->getMock('Querformatik\HelfenKannJeder\Domain\Model\Organisation');
	}

	/**
	 * @test
	 * @return void
	 */
	public function testBuildOrganisationInfo() {
		$grade = 123.12;
		$distance = 12.1;
		$uriBuilder = function ($uid) {
			return 'URL_FOR_' . $uid;
		};

		$this->assertEquals(NULL, $this->fixture->buildOrganisationInfo(NULL, $grade, $distance, $uriBuilder));

		$this->organisation1
			->expects($this->any())
			->method('getUid')
			->will($this->returnValue(1337123));

		$this->organisation1
			->expects($this->once())
			->method('getName')
			->will($this->returnValue('Test Organisation'));

		$this->organisationType
			->expects($this->once())
			->method('getUid')
			->will($this->returnValue(7443));

		$this->organisation1
			->expects($this->once())
			->method('getOrganisationtype')
			->will($this->returnValue($this->organisationType));

		$this->organisation1
			->expects($this->once())
			->method('getDescription')
			->will($this->returnValue('Description Test'));

		$this->organisation1
			->expects($this->once())
			->method('getIsDummy')
			->will($this->returnValue(FALSE));

		$this->assertEquals(array(
			'uid' => 1337123,
			'name' => 'Test Organisation',
			'organisationtype' => 7443,
			'description' => 'Description Test',
			'grade' => $grade,
			'link' => 'URL_FOR_1337123',
			'distance' => $distance,
			'is_dummy' => FALSE,
		), $this->fixture->buildOrganisationInfo($this->organisation1, $grade, $distance, $uriBuilder));
	}

}
