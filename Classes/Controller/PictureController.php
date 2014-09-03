<?php
class Tx_HelfenKannJeder_Controller_PictureController
	extends Tx_Extbase_MVC_Controller_ActionController {
	protected $organisationRepository;
	protected $configurationManager;
	protected $contentObject;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Repository_OrganisationTypeRepository
	 * @inject
	 */
	protected $organisationTypeRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Service\ImageService
	 * @inject
	 */
	protected $imageService;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('Tx_HelfenKannJeder_Domain_Repository_OrganisationRepository');

		$this->configurationManager = $this->objectManager->get("Tx_Extbase_Configuration_ConfigurationManager");
		$this->contentObject = $this->configurationManager->getContentObject();
	}

	public function indexAction() {
		// TODO: Use FAL instead of absolute paths
		// TODO: Bilder Pfad (uploads/pics/) aus Templates auslagern
		$rotatingPictures = array();

		foreach ($this->organisationTypeRepository->findAll() as $organisationType) {
			$pictures = explode(',', $organisationType->getTeaser());

			foreach ($pictures as $picture) {
				if (!empty($picture)) {
					$src = "uploads/pics/".$picture;
					$width = 260;
					$height = 183;
					if ($this->imageService != null) {
						$image = $this->imageService->getImage($src, null, false); // TODO: Use a fal object instead
						$processingInstructions = array(
							'width' => $width."c",
							'height' => $height."c",
							'minWidth' => $width,
							'minHeight' => $height,
							'maxWidth' => $width,
							'maxHeight' => $height,
						);
						$processedImage = $this->imageService->applyProcessingInstructions($image, $processingInstructions);
						$imageUri = $this->imageService->getImageUri($processedImage);
						$rotatingPictures[$organisationType->getUid()][] = $imageUri;
					} else { // TODO: Remove deprecated code (used in TYPO3 6.1 and below
						$minWidth = $width;
						$minHeight = $height;
						$maxWidth = $width;
						$maxHeight = $height;
						$setup = array(
							'width' => $width."c",
							'height' => $height."c",
							'minW' => $minWidth,
							'minH' => $minHeight,
							'maxW' => $maxWidth,
							'maxH' => $maxHeight
						);
						if (TYPO3_MODE === 'BE' && substr($src, 0, 3) === '../') {
							$src = substr($src, 3);
						}
						$imageInfo = $this->contentObject->getImgResource($src, $setup);
						$GLOBALS['TSFE']->lastImageInfo = $imageInfo;
						if (is_array($imageInfo)) {
							$GLOBALS['TSFE']->imagesOnPage[] = $imageInfo[3];
							$rotatingPictures[$organisationType->getUid()][] = $imageInfo[3];
						}
					} // End of deprecated code
				}
			}
		}

		$this->view->assign('rotatingPictures', $rotatingPictures);
	}
}
?>
