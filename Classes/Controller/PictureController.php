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

class PictureController
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	protected $organisationRepository;
	protected $configurationManager;
	protected $contentObject;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationTypeRepository
	 * @inject
	 */
	protected $organisationTypeRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Service\ImageService
	 */
	protected $imageService;

	public function initializeAction() {
		$this->organisationRepository = $this->objectManager->get('\\Querformatik\\HelfenKannJeder\\Domain\\Repository\\OrganisationRepository');

		$this->configurationManager = $this->objectManager->get("\\TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager");
		$this->contentObject = $this->configurationManager->getContentObject();

		if (class_exists("\\TYPO3\\CMS\\Extbase\\Service\\ImageService")) {
			$this->imageService = $this->objectManager->get("\\TYPO3\\CMS\\Extbase\\Service\\ImageService");
		}
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
