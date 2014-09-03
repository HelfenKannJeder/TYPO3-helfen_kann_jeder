<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-11-30
 */
class Tx_HelfenKannJeder_Domain_Model_EmployeeDraft extends Tx_HelfenKannJeder_Domain_Model_Employee {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_OrganisationDraft
	 */
	protected $organisation;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Employee
	 * @lazy
	 */
	protected $reference;
}
?>
