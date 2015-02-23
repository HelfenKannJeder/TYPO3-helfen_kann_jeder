<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Image;

class AllViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper {

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
	 * @param string $rel path for rel argument
	 * @param string $lightboxHeight path for rel argument
	 * @param string $lightboxWidth path for rel argument
	 * @param string $align alignment from image
	 *
	 * @return string rendered tag.
	 * @author Sebastian Böttger <sboettger@cross-content.com>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @author Valentin Zickner <zickner@querformatik.de>
	 */
	public function render($src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL, $path = NULL, $rel = NULL,
					$lightboxHeight = NULL, $lightboxWidth = NULL, $align = NULL) {
		if (class_exists("\\TYPO3\\CMS\\Extbase\\Service\\ImageService")) {
			$this->imageService = $this->objectManager->get("\\TYPO3\\CMS\\Extbase\\Service\\ImageService");
		}

		if (empty($src)) {
			return "";
		}

		$srcs = explode(",", $src);

		$rendered = "";
		foreach ($srcs as $src) {
			$orgsrc = $src;
			if (is_string($path)) {
				$src = $path . $src;
			}
        
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

			$this->tag->addAttribute('src', $imageSource);
			$this->tag->addAttribute('width', $imageInfo[0]);
			$this->tag->addAttribute('height', $imageInfo[1]);
			if ($align != null) $this->tag->addAttribute('align', $align);
			if ($this->arguments['title'] === '') {
				$this->tag->addAttribute('title', $this->arguments['alt']);
			}

			if (!empty($rel) && !empty($lightboxWidth) && !empty($lightboxHeight)) {
				$setup = array(
					'width' => $lightboxWidth,
					'height' => $lightboxHeight,
				);
				$image = null;
				$image = $this->imageService->getImage($src, $image, $treatIdAsReference);
				$processedImage = $this->imageService->applyProcessingInstructions($image, $setup);
				$imageSource = $this->imageService->getImageUri($processedImage);

				$link = new \TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder('a', $this->tag->render());
				$link->addAttribute("href", $imageSource);
				$link->addAttribute("rel", $rel);
				$result = $link->render();
                                
				$rendered .= $result;
			} else {
				$this->templateVariableContainer->add("path", $orgsrc);
				$rendered .= $this->renderChildren();
				$rendered .= $this->tag->render();
				$this->templateVariableContainer->remove("path");
			}
		}
		return $rendered;
	}
}
?>
