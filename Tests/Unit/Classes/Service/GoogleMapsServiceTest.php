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
namespace Querformatik\HelfenKannJeder\Tests\Unit;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Unit test for google maps service
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
	 * Test the convertion of an address to an latitude and longitude
	 *
	 * @test
	 * @return void
	 */
	public function testCalculateCityAndDepartment() {
		$addresses = $this->googleMapsService->calculateCityAndDepartment('Gruenhutstr. 9, 76187 Karlsruhe');
		$this->assertEquals(1, count($addresses));

		$address = current($addresses);
		$this->assertEquals(49.038276, $address['latitude']);
		$this->assertEquals(8.351941, $address['longitude']);
		$this->assertEquals('Karlsruhe', $address['locality']);
		$this->assertEquals('BW', $address['administrative_area_level_1_short']);
		$this->assertEquals('Deutschland', $address['country']);
		$this->assertEquals('DE', $address['country_short']);
	}

	/**
	 * Test the convertion of an german zipcode
	 *
	 * @test
	 * @return void
	 */
	public function testCalculateCityAndDepartmentForZipcode() {
		$addresses = $this->googleMapsService->calculateCityAndDepartment('Germany, 76133');
		$this->assertEquals(1, count($addresses));
		$this->assertTrue($addresses[0]['locality'] != '');
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
