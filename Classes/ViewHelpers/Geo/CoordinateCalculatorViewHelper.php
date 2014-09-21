<?php
namespace Querformatik\HelfenKannJeder\ViewHelpers\Geo;

class CoordinateCalculatorViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @param integer $coordinate First value.
	 * @return text coordinate readable
	 */
	public function render($coordinate = NULL) {
		if ($coordinate === NULL) {
			$coordinate = $this->renderChildren();
		}

		$coordinate = (float)$coordinate;
		$coordinate_degrees = (int)$coordinate;
		$coordinate = ($coordinate-$coordinate_degrees)*60;
		$coordinate_minutes = (int)$coordinate;
		$coordinate_seconds = (int)(($coordinate-$coordinate_minutes)*60);

		$text = $coordinate_degrees.'° '.$coordinate_minutes.'\' '.$coordinate_seconds.'"';

		return $text;
	}
}
?>
