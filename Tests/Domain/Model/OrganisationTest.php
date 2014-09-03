<?php
class Tx_HelfenKannJeder_Domain_Model_OrganisationTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @test
	 */
	public function anInstanceOfTheOrganisationCanBeConstructed() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$this->assertEquals('Name', $organisation->getName());
	}

	/**
	 * @test
	 */
	public function aNameCanBeSet() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$organisation->setName("New Name");
		$this->assertEquals('New Name', $organisation->getName());
	}

	/**
	 * @test
	 */
	public function aDescriptionCanBeSet() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$organisation->setDescription("New Description");
		$this->assertEquals('New Description', $organisation->getDescription());
	}

	/**
	 * @test
	 */
	public function aWebsiteCanBeSet() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$organisation->setWebsite("http://www.thw-karlsruhe.de/");
		$this->assertEquals('http://www.thw-karlsruhe.de/', $organisation->getWebsite());
	}

	/**
	 * @test
	 */
	public function aStreetCanBeSet() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$organisation->setStreet('Street 123');
		$this->assertEquals('Street 123', $organisation->getStreet());
	}

	/**
	 * @test
	 */
	public function aCityCanBeSet() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$organisation->setCity('Karlsruhe');
		$this->assertEquals('Karlsruhe', $organisation->getCity());
	}

	/**
	 * @test
	 */
	public function aPicturesCanBeSet() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$organisation->setPictures('fileadmin/test.jpg');
		$this->assertEquals('fileadmin/test.jpg', $organisation->getPictures());
	}

	/*
	 * @test
	 */
	public function aFrontendUserCanBeSet() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$mockFrontendUser = $this->getMock('Tx_Extbase_Domain_Model_FrontendUser');
		$organisation->setFeUser($mockFrontendUser);
		$this->assertEquals($mockFrontendUser, $organisation->getFeUser());
	}

	/**
	 * @test
	 */
	public function theActivityFieldsAreInitializedAsEmptyObjectStorage() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($organisation->getActivityFieldLayers()));
		$this->assertEquals(0, count($organisation->getActivityFieldLayers()));
	}

	/**
	 * @test
	 */
	public function aActivityFieldCanBeAdded() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$mockActivityFieldLayer = $this->getMock('Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer');
		$organisation->addActivityFieldLayer($mockActivityFieldLayer);
		$this->assertTrue($organisation->getActivityFieldLayers()->contains($mockActivityFieldLayer));
	}

	/**
	 * @test
	 */
	public function theGroupsAreInitializedAsEmptyObjectStorage() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($organisation->getGroups()));
		$this->assertEquals(0, count($organisation->getGroups()));
	}

	/**
	 * @test
	 */
	public function aGroupCanBeAdded() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$mockGroup = $this->getMock('Tx_HelfenKannJeder_Domain_Model_Group');
		$organisation->addGroup($mockGroup);
		$this->assertTrue($organisation->getGroups()->contains($mockGroup));
	}

	/**
	 * @test
	 */
	public function theEmployeesAreInitializedAsEmptyObjectStorage() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($organisation->getEmployees()));
		$this->assertEquals(0, count($organisation->getEmployees()));
	}

	/**
	 * @test
	 */
	public function aEmployeeCanBeAdded() {
		$organisation = new Tx_HelfenKannJeder_Domain_Model_Organisation('Name');
		$mockEmployee = $this->getMock('Tx_HelfenKannJeder_Domain_Model_Employee');
		$organisation->addEmployee($mockEmployee);
		$this->assertTrue($organisation->getEmployees()->contains($mockEmployee));
	}
}
