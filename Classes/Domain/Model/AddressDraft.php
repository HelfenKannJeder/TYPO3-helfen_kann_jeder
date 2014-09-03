<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-11-29
 */
class Tx_HelfenKannJeder_Domain_Model_AddressDraft extends Tx_HelfenKannJeder_Domain_Model_Address {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_OrganisationDraft
	 */
	protected $organisation;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Address
	 * @lazy
	 */
	protected $reference;

}
?>
