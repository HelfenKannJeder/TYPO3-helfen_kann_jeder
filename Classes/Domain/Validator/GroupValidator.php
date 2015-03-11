<?php
namespace Querformatik\HelfenKannJeder\Domain\Validator;

/**
 * Validates a group for correctness.
 *
 * @author Valentin Zickner
 */
class GroupValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {
	public function isValid($group) {
		if (! $group instanceof \Querformatik\HelfenKannJeder\Domain\Model\Group) {
			$this->addError('The given Object is not a group.', 1307884111);
			return FALSE;
		}
		if (strlen($group->getName()) < 3) {
			$this->addError('The name is to short.', 1307884413);
			return FALSE;
		}
		return TRUE;
	}
}
