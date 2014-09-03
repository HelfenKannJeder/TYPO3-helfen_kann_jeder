<?php
class Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayerTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @test
	 */
	public function anInstanceOfTheActivityFieldLayerCanBeConstructed() {
		$mockActivityField = $this->getMock('Tx_Extbase_Domain_Model_ActivityField');
		$mockOrganisation = $this->getMock('Tx_Extbase_Domain_Model_Organisation');


		$activityFieldLayer = new Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer(
			$mockActivityField, $mockOrganisation, 1
		);
		$this->assertEquals($mockActivityField, $activityFieldLayer->getActivityField());
		$this->assertEquals($mockOrganisation, $activityFieldLayer->getOrganisation());
		$this->assertEquals(1, $activityFieldLayer->getGrade());
	}

	/**
	 * @test
	 */
	public function anActivityFieldCanBeSet() {
		$mockActivityField = $this->getMock('Tx_Extbase_Domain_Model_ActivityField');

		$activityFieldLayer = new Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer();
		$activityFieldLayer->setActivityField($mockActivityField);
		$this->assertEquals($mockActivityField, $activityFieldLayer->getActivityField());
	}

	/**
	 * @test
	 */
	public function aOrganisationCanBeSet() {
		$mockOrganisation = $this->getMock('Tx_Extbase_Domain_Model_Organisation');

		$activityFieldLayer = new Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer();
		$activityFieldLayer->setOrganisation($mockOrganisation);
		$this->assertEquals($mockOrganisation, $activityFieldLayer->getOrganisation());
	}

	/**
	 * @test
	 */
	public function aGradeCanBeSet() {
		$activityFieldLayer = new Tx_HelfenKannJeder_Domain_Model_ActivityFieldLayer();
		$activityFieldLayer->setGrade(1);
		$this->assertEquals(1, $activityFieldLayer->getGrade());

		$activityFieldLayer->setGrade(0);
		$this->assertEquals(0, $activityFieldLayer->getGrade());
	}
}
?>
