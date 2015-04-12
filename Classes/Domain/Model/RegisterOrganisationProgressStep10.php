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
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This is an assistant class which stores user information while
 * the user try to register an account.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-10-07
 */
class RegisterOrganisationProgressStep10 extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	/**
	 * @var boolean
	 * @validate Boolean(is=true)
	 */
	protected $agreement = FALSE;

	/**
	 * captcha
	 *
	 * @var string
	 * @validate \SJBR\SrFreecap\Validation\Validator\CaptchaValidator
	 * @validate NotEmpty
	 */
	protected $captcha;

	/**
	 * @param $agreement Applied agreement
	 * @return void
	 */
	public function setAgreement($agreement) {
		$this->agreement = $agreement;
	}

	public function getAgreement() {
		return $this->agreement;
	}

	/**
	 * @param $captcha CAPTCHA for user input
	 * @return void
	 */
	public function setCaptcha($captcha) {
		$this->captcha = $captcha;
	}

	public function getCaptcha() {
		return $this->captcha;
	}

}
