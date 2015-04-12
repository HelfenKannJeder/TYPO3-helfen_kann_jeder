<?php
/*
 * Copyright (C) 2015 Valentin Zickner <valentin.zickner@helfenkannjeder.de>
 *
 * This file is part of HelfenKannJeder.
 *
 * HelfenKannJeder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HelfenKannJeder is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HelfenKannJeder.  If not, see <http://www.gnu.org/licenses/>.
 */
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
