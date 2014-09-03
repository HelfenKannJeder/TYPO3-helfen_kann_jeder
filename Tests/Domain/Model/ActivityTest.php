<?php
class Tx_HelfenKannJeder_Domain_Model_ActivityTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @test
	 */
	public function anInstanceOfTheActivityCanBeConstructed() {
		$activity = new Tx_HelfenKannJeder_Domain_Model_Activity('Name');
		$this->assertEquals('Name', $activity->getName());
	}

	/**
	 * @test
	 */
	public function aNameCanBeSet() {
		$activity = new Tx_HelfenKannJeder_Domain_Model_Activity('Name');
		$activity->setName("New Name");
		$this->assertEquals('New Name', $activity->getName());
	}

	/**
	 * @test
	 */
	public function theActivityFieldsAreInitializedAsEmptyObjectStorage() {
		$activity = new Tx_HelfenKannJeder_Domain_Model_Activity('Name');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($activity->getActivityFields()));
		$this->assertEquals(0, count($activity->getActivityFields()));
	}

	/**
	 * @test
	 */
	public function aActivityFieldCanBeAdded() {
		$activity = new Tx_HelfenKannJeder_Domain_Model_Activity('Name');
		$mockActivityField = $this->getMock('Tx_HelfenKannJeder_Domain_Model_ActivityField');
		$activity->addActivityField($mockActivityField);
		$this->assertTrue($activity->getActivityFields()->contains($mockActivityField));
	}
}
?>
