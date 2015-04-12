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
 * Test for SupportService for finding the corrospondending user
 *
 * @author Valentin Zickner
 */
class SupportServiceTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\SupportService
	 */
	protected $supportService;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->supportService = GeneralUtility::makeInstance('Querformatik\\HelfenKannJeder\\Service\\SupportService');
	}

	/**
	 * Test the phone number normalization
	 *
	 * @test
	 * @return void
	 */
	public function testFindSupporter() {
//		$mockRepository = $this->getMock('\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository');
//		$mockQuery = $this->getMock('TYPO3\CMS\Extbase\Persistence\QueryInterface');
//		$mockRepository->expects($this->once())->method('findAll')->will($this->returnValue($mockQuery));
//		$this->inject($this->supportService, 'frontendUserGroupRepository', $mockRepository);
//
//		$this->supportService->findSupporter($location, $supporterGroupId, $organisationtype = NULL);
	}
}
