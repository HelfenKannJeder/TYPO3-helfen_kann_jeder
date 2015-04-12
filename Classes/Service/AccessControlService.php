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
namespace Querformatik\HelfenKannJeder\Service;

class AccessControlService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\SupporterRepository
	 * @inject
	 */
	protected $supporterRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $feUserRepository;

	public function isLoggedIn($person = NULL) {
		if (is_object($person)) {
			if ($person->getUid() === $this->getFrontendUserUid()) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public function setFrontendUserUid($uid) {
		$rSql = $GLOBALS["TYPO3_DB"]->exec_SELECTquery(
			"*",
			"fe_users",
			"uid='".((int)$uid)."'"
		);

		if(($aUser = $GLOBALS["TYPO3_DB"]->sql_fetch_assoc($rSql)) !== FALSE) {
			$GLOBALS["TSFE"]->fe_user->createUserSession($aUser);
			$GLOBALS["TSFE"]->fe_user->loginSessionStarted = TRUE;
			$GLOBALS["TSFE"]->fe_user->user = $GLOBALS["TSFE"]->fe_user->fetchUserSession();
		}
	}

	public function setFrontendUserNone() {
		$GLOBALS["TSFE"]->fe_user->loginSessionStarted = FALSE;
		$GLOBALS["TSFE"]->fe_user->user = null;
	}

	public function getFrontendUserUid() {
		if (!empty($GLOBALS['TSFE']->fe_user->user['uid'])) {
			return intval($GLOBALS['TSFE']->fe_user->user['uid']);
		}
		return NULL;
	}

	public function getSessionId() {
		return $GLOBALS['TSFE']->fe_user->id;
	}

	public function setSessionVariable($variable, $content) {
		$GLOBALS["TSFE"]->fe_user->setKey("ses", $variable, $content);
	}

	public function getSessionVariable($variable) {
		return $GLOBALS['TSFE']->fe_user->getKey('ses', $variable);
	}

	public function removeSessionVariable($variable) {
		$this->setSessionVariable($variable, NULL);
	}

	public function getFrontendSupporter() {
		return $this->supporterRepository->findByUid($this->getFrontendUserUid());
	}

	public function getFrontendUser() {
		return $this->feUserRepository->findByUid($this->getFrontendUserUid());
	}

	public function hasLoggedInFrontendUser() {
		return $GLOBALS['TSFE']->loginUser === TRUE || $GLOBALS['TSFE']->loginUser === 1 ? TRUE : FALSE;
	}
}
?>
