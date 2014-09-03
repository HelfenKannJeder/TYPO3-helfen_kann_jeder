<?php
class Tx_HelfenKannJeder_Domain_Model_GroupTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @test
	 */	
	public function anInstanceOfTheGroupCanBeConstructed() {
		$group = new Tx_HelfenKannJeder_Domain_Model_Group('Name');
		$this->assertEquals('Name', $group->getName());
	}

	/**
	 * @test
	 */
	public function aNameCanBeSet() {
		$group = new Tx_HelfenKannJeder_Domain_Model_Group('Name');
		$group->setName("New Name");
		$this->assertEquals('New Name', $group->getName());
	}

	/**
	 * @test
	 */
	public function aOrganisationCanBeSet() {
		$mockOrganisation = $this->getMock('Tx_HelfenKannJeder_Domain_Model_Organisation');
		$group = new Tx_HelfenKannJeder_Domain_Model_Group('Name');
		$group->setOrganisation($mockOrganisation);
		$this->assertEquals($mockOrganisation, $group->getOrganisation());
	}

	/**
	 * @test
	 */
	public function aDescriptionCanBeSet() {
		$group = new Tx_HelfenKannJeder_Domain_Model_Group('Name');
		$group->setDescription('This is an example description');
		$this->assertEquals('This is an example description', $group->getDescription());
	}

	/**
	 * @test
	 */
	public function aMinimumAgeCanBeSet() {
		$group = new Tx_HelfenKannJeder_Domain_Model_Group('Name');
		$group->setMinimumAge(18);
		$this->assertEquals(18, $group->getMinimumAge());
	}

	/**
	 * @test
	 */
	public function aMaximumAgeCanBeSet() {
		$group = new Tx_HelfenKannJeder_Domain_Model_Group('Name');
		$group->setMaximumAge(17);
		$this->assertEquals(17, $group->getMaximumAge());
	}
}
?>
