<?php
class Tx_HelfenKannJeder_Domain_Model_InterestedPersonTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @test
	 */
	public function anInstanceOfTheInterestedPersonCanBeConstructed() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$this->assertEquals('sessionid', $interestedPerson->getSessionid());
	}

	/**
	 * @test
	 */
	public function theOrganisationsAreInitializedAsEmptyObjectStorage() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($interestedPerson->getOrganisations()));
		$this->assertEquals(0, count($interestedPerson->getOrganisations()));
	}

	/**
	 * @test
	 */
	public function aOrganisationCanBeAdded() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$mockOrganisation = $this->getMock('Tx_HelfenKannJeder_Domain_Model_Organisation');
		$interestedPerson->addOrganisation($mockOrganisation);
		$this->assertTrue($interestedPerson->getOrganisations()->contains($mockOrganisation));
	}

	/**
	 * @test
	 */
	public function theActivitiesAreInitializedAsEmptyObjectStorage() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$this->assertEquals('Tx_Extbase_Persistence_ObjectStorage',
			get_class($interestedPerson->getActivities()));
		$this->assertEquals(0, count($interestedPerson->getActivities()));
	}

	/**
	 * @test
	 */
	public function anActivityCanBeAdded() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$mockActivity = $this->getMock('Tx_HelfenKannJeder_Domain_Model_Activity');
		$interestedPerson->addActivity($mockActivity);
		$this->assertTrue($interestedPerson->getActivities()->contains($mockActivity));
	}

	/**
	 * @test
	 */
	public function aSessionidCanBeSet() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$interestedPerson->setSessionid('newsessionid');
		$this->assertEquals('newsessionid', $interestedPerson->getSessionid());
	}

	/**
	 * @test
	 */
	public function aIpCanBeSet() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$interestedPerson->setIp('127.0.0.1');
		$this->assertEquals('127.0.0.1', $interestedPerson->getIp());
	}

	/**
	 * @test
	 */
	public function aLastActivityCanBeSet() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$currentTime = time();
		$interestedPerson->setLastActivity($currentTime);
		$this->assertEquals($currentTime, $interestedPerson->getLastActivity());
	}

	/**
	 * @test
	 */
	public function anAgeCanBeSet() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$interestedPerson->setAge(19);
		$this->assertEquals(19, $interestedPerson->getAge());
	}

	/**
	 * @test
	 */
	public function anCityCanBeSet() {
		$interestedPerson = new Tx_HelfenKannJeder_Domain_Model_InterestedPerson('sessionid');
		$interestedPerson->setCity('Karlsruhe');
		$this->assertEquals('Karlsruhe', $interestedPerson->getCity());
	}
}
?>
