<?php
class Tx_HelfenKannJeder_Domain_Model_EmployeeTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @test
	 */
	public function anInstanceOfTheEmployeeCanBeConstructed() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Name', 'Prename');
		$this->assertEquals('Name', $employee->getSurname());
		$this->assertEquals('Prename', $employee->getPrename());
	}

	/**
	 * @test
	 */
	public function aNameCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Name', 'Prename');
		$employee->setSurname('My Name');
		$this->assertEquals('My Name', $employee->getSurname());
	}

	/**
	 * @test
	 */
	public function aPrenameCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setPrename('My Prename');
		$this->assertEquals('My Prename', $employee->getPrename());
	}

	/**
	 * @test
	 */
	public function aPicturesCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setPictures('fileadmin/image.jpg');
		$this->assertEquals('fileadmin/image.jpg', $employee->getPictures());
	}

	/**
	 * @test
	 */
	public function aRankCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setRank('B1 Helfer');
		$this->assertEquals('B1 Helfer', $employee->getRank());
	}

	/**
	 * @test
	 */
	public function aMotiviationCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setMotivation('My Motivation');
		$this->assertEquals('My Motivation', $employee->getMotivation());
	}

	/**
	 * @test
	 */
	public function aBirthdayCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$birthday = mktime(0,0,0,5,12,1980); // generate birthday integer (unix timestamp)
		$employee->setBirthday($birthday);
		$this->assertEquals($birthday, $employee->getBirthday());
	}

	/**
	 * @test
	 */
	public function aMailCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setMail('valentin.zickner@thw-karlsruhe.de');
		$this->assertEquals('valentin.zickner@thw-karlsruhe.de', $employee->getMail());
	}

	/**
	 * @test
	 */
	public function aStreetCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setStreet('Sudetenstrasse 132');
		$this->assertEquals('Sudetenstrasse 132', $employee->getStreet());
	}

	/**
	 * @test
	 */
	public function aCityCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setCity('Karlsruhe');
		$this->assertEquals('Karlsruhe', $employee->getCity());
	}

	/**
	 * @test
	 */
	public function isContactCanBeSet() {
		$employee = new Tx_HelfenKannJeder_Domain_Model_Employee('Surname', 'Prename');
		$employee->setIsContact(true);
		$this->assertEquals(true, $employee->getIsContact());
	}
}
?>
