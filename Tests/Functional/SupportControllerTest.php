<?php
namespace Querformatik\HelfenKannJeder\Tests\Functional;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Fractional test for support controller, see also http://wiki.typo3.org/Functional_testing
 */
class SupportControllerTest extends \TYPO3\CMS\Core\Tests\FunctionalTestCase {

	const VALUE_PageId = 89;
	const VALUE_PageIdTarget = 90;
	const VALUE_PageIdWebsite = 1;

	/**
	 * @var array
	 */
	protected $coreExtensionsToLoad = array('extbase', 'fluid', 'workspaces');

	/**
	 * @var array
	 */
	protected $testExtensionsToLoad = array(
		'typo3conf/ext/qu_base',
		'typo3conf/ext/helfen_kann_jeder',
	);

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface The object manager
	 */
	protected $objectManager;


	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 */
	protected $persistentManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 */
	protected $organisationDraftRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationRepository
	 */
	protected $organisationRepository;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\DraftToLiveService
	 */
	protected $draftToLiveService;

	public function setUp() {
		parent::setUp();

		$this->importDataSet(ORIGINAL_ROOT . 'typo3/sysext/core/Tests/Functional/Fixtures/pages.xml');

		$this->setUpFrontendRootPage(
			1,
			array(
				'typo3conf/ext/helfen_kann_jeder/Tests/Functional/Fixtures/TypoScript.ts',
			)
		);

		$this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/helfen_kann_jeder/Tests/Functional/Fixtures/OrganisationData.xml');

		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->persistentManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		$this->organisationDraftRepository = $this->objectManager->get('Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationDraftRepository');
		$this->organisationRepository = $this->objectManager->get('Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');
		$this->draftToLiveService = $this->objectManager->get('Querformatik\\HelfenKannJeder\\Service\\DraftToLiveService');
	}

	public function testCountDraftObjects() {
		$this->assertSame(2, count($this->organisationDraftRepository->findAll()));
	}

	public function testSyncObjects() {
		$firstOrganisation = $this->organisationDraftRepository->findByUid(1);
		$this->assertNotSame(null, $firstOrganisation);
		$this->draftToLiveService->draft2live($firstOrganisation);
		$this->assertSame(1, count($this->organisationRepository->findAll()));
	}
}
?>
