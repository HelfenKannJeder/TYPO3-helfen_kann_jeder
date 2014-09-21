<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-12-09
 */
class GroupDraft extends Group {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 */
	protected $organisation;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Querformatik\HelfenKannJeder\Domain\Model\EmployeeDraft>
	 * @lazy
	 */
	protected $contactpersons;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Group
	 * @lazy
	 */
	protected $reference;

}
?>
