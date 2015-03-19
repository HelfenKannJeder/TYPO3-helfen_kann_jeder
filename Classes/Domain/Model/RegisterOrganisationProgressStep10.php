<?php
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
