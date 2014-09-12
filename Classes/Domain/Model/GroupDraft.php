<?php
/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-12-09
 */
class Tx_HelfenKannJeder_Domain_Model_GroupDraft extends Tx_HelfenKannJeder_Domain_Model_Group {
	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_OrganisationDraft
	 */
	protected $organisation;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_HelfenKannJeder_Domain_Model_EmployeeDraft>
	 * @lazy
	 */
	protected $contactpersons;

	/**
	 * @var Tx_HelfenKannJeder_Domain_Model_Group
	 * @lazy
	 */
	protected $reference;

}
?>
