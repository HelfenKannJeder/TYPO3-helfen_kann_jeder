<?php
class Tx_HelfenKannJeder_ViewHelpers_Geo_DistanceViewHelper
	extends Tx_Fluid_ViewHelpers_BaseViewHelper {

	/**
	 * @var Tx_HelfenKannJeder_Service_GoogleMapsService
	 * @inject
	 */
	protected $googleMapsService;

	/**
	 * Calculate distance approximately between two coordinates.
	 *
	 * @param float p1lat Latitude from first coordinate
	 * @param float p1lng Longitude from first coordinate
	 * @param float p2lat Latitude from second coordinate
	 * @param float p2lng Longitude from second coordinate
	 * @return Distance between two points.
	 */
	public function render($p1lat, $p1lng, $p2lat, $p2lng) {
		return $this->googleMapsService->approxDistance($p1lat, $p1lng, $p2lat, $p2lng);
	}
}
?>
