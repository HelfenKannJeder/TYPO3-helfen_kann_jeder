<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents working hours of an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2012-01-11
 */
class WorkinghourDraft extends Workinghour {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 */
	protected $organisation;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\GroupDraft>
	 */
	protected $groups;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\AddressDraft
	 */
	protected $address;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Workinghour
	 * @lazy
	 */
	protected $reference;
}
?>
