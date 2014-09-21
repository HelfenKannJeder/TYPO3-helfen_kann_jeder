<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents an organisation.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-11-30
 */
class EmployeeDraft extends Employee {
	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\OrganisationDraft
	 */
	protected $organisation;

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Model\Employee
	 * @lazy
	 */
	protected $reference;
}
?>
