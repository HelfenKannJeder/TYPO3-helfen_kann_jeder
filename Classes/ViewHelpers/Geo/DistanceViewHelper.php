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
namespace Querformatik\HelfenKannJeder\ViewHelpers\Geo;

class DistanceViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper {

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\GoogleMapsService
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
