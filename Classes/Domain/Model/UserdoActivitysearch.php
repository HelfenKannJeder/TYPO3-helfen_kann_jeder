<?php
namespace Querformatik\HelfenKannJeder\Domain\Model;

/**
 * "Helfen Kann Jeder" Project
 *
 * @description: This class represents a user.
 * @author: Valentin Zickner
 *    Querformatik UG (haftungsbeschraenkt)
 *    Technisches Hilfswerk Karlsruhe
 * @date: 2011-08-19
 */
class UserdoActivitysearch extends Userdo {
	/**
	 * @var string
	 */
	protected $input;

	/**
	 * @var string
	 */
	protected $result;

	public function setInput($input) {
		$this->input = $input;
	}

	public function getInput() {
		return $this->input;
	}

	public function setResult($result) {
		$this->result = $result;
	}

	public function getResult() {
		return $this->result;
	}
}
?>
