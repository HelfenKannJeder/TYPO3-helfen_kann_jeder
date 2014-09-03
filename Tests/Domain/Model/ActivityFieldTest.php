<?php
class Tx_HelfenKannJeder_Domain_Model_ActivityFieldTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @test
	 */
	public function anInstanceOfTheActivityFieldCanBeConstructed() {
		$activityField = new Tx_HelfenKannJeder_Domain_Model_ActivityField('Name');
		$this->assertEquals('Name', $activityField->getName());
	}

	/**
	 * @test
	 */
	public function aNameCanBeSet() {
		$activityField = new Tx_HelfenKannJeder_Domain_Model_ActivityField('Name');
		$activityField->setName("New Name");
		$this->assertEquals('New Name', $activityField->getName());
	}

	/**
	 * @test
	 */
	public function theActivityFieldLayersAreInitializedAsEmptyObjectStorage() {
		$activityField = new Tx_HelfenKannJeder_Domain_Model_ActivityField('Name');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($activityField->getActivityFieldLayers()));
		$this->assertEquals(0, count($activityField->getActivityFieldLayers()));
	}

	/**
	 * @test
	 */
	public function aActivityFieldLayerCanBeAdded() {
		$activityField = new Tx_HelfenKannJeder_Domain_Model_ActivityField('Name');
		$mockActivityFieldLayer = $this->getMock('Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer');
		$activityField->addActivityFieldLayer($mockActivityFieldLayer);
		$this->assertTrue($activityField->getActivityFieldLayers()->contains($mockActivityFieldLayer));
	}

	/**
	 * @test
	 */
	public function theActivitiesAreInitializedAsEmptyObjectStorage() {
		$activityField = new Tx_HelfenKannJeder_Domain_Model_ActivityField('Name');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($activityField->getActivities()));
		$this->assertEquals(0, count($activityField->getActivities()));
	}

	/**
	 * @test
	 */
	public function aActivityCanBeAdded() {
		$activityField = new Tx_HelfenKannJeder_Domain_Model_ActivityField('Name');
		$mockActivity = $this->getMock('Tx_HelfenKannJeder_Domain_Model_Activity');
		$activityField->addActivity($mockActivity);
		$this->assertTrue($activityField->getActivities()->contains($mockActivity));
	}
}
?>
