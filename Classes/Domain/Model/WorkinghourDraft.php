<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents working hours of an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-11
 */
class Tx_HelfenKannJeder_Domain_Model_WorkinghourDraft
		extends Tx_HelfenKannJeder_Domain_Model_Workinghour {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_OrganisationDraft
	 */
	protected $organisation;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_GroupDraft>
	 */
	protected $groups;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_AddressDraft
	 */
	protected $address;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Workinghour
	 * @lazy
	 */
	protected $reference;
}
?>
