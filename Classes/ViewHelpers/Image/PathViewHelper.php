<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Image;

class PathViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper {

	/**
	 * @var \TYPO3\CMS\Extbase\Service\ImageService
	 */
	protected $imageService;

	/**
	 * Resizes a given image (if required) and renders the respective img tag
	 * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
	 *
	 * @param string $src
	 * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param integer $minWidth minimum width of the image
	 * @param integer $minHeight minimum height of the image
	 * @param integer $maxWidth maximum width of the image
	 * @param integer $maxHeight maximum height of the image
	 * @param string $path the path to the folder, where the image found
	 *
	 * @return string rendered tag.
	 * @author Sebastian Böttger <sboettger@cross-content.com>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @author Valentin Zickner <zickner@querformatik.de>
	 */
	public function render($src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL, $path = NULL) {
		if (class_exists("\\TYPO3\\CMS\\Extbase\\Service\\ImageService")) {
			$this->imageService = $this->objectManager->get("\\TYPO3\\CMS\\Extbase\\Service\\ImageService");
		}

		if (empty($src)) {
			return "";
		}

		if (is_string($path)) {
			$src = $path . $src;
		}

		if (strpos($src, ',')) {
			$src = substr($src, 0, strpos($src, ','));
		}

		if ($this->imageService != null) { // TODO: Clean code
			$image = null;
			$image = $this->imageService->getImage($src, $image, $treatIdAsReference);
			$processingInstructions = array(
				'width' => $width,
				'height' => $height,
				'minWidth' => $minWidth,
				'minHeight' => $minHeight,
				'maxWidth' => $maxWidth,
				'maxHeight' => $maxHeight,
			);
			$processedImage = $this->imageService->applyProcessingInstructions($image, $processingInstructions);
			$imageSource = $this->imageService->getImageUri($processedImage);
		} else {
			$setup = array(
				'width' => $width,
				'height' => $height,
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
			if (!is_array($imageInfo)) {
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Could not get image resource for "' . htmlspecialchars($src) . '".' , 1253191060);
			}
			$imageInfo[3] = \TYPO3\CMS\Core\Utility\GeneralUtility::png_to_gif_by_imagemagick($imageInfo[3]);
			$GLOBALS['TSFE']->imagesOnPage[] = $imageInfo[3];
                        
			$imageSource = $GLOBALS['TSFE']->absRefPrefix . \TYPO3\CMS\Core\Utility\GeneralUtility::rawUrlEncodeFP($imageInfo[3]);
			if (TYPO3_MODE === 'BE') {
				$imageSource = '../' . $imageSource;
				$this->resetFrontendEnvironment();
			}
		}

		return $imageSource;
	}
}
?>
