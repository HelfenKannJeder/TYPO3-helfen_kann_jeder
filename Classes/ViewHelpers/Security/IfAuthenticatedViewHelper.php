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
namespace Querformatik\HelfenKannJeder\ViewHelpers\Security;

class IfAuthenticatedViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper {

	/**
	 * @var \Querformatik\HelfenKannJeder\Service\AccessControlService
	 * @inject
	 */
	protected $accessControlService;

	/**
	 * @param mixed $person The person to be tested for login
	 * @return string The output
	 */
	public function render($person = NULL) {
		if ($this->accessControlService->isLoggedIn($person)) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}
?>
