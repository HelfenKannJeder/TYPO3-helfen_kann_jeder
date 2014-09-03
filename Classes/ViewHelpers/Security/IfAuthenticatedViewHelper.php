<?php
class Tx_HelfenKannJeder_ViewHelpers_Security_IfAuthenticatedViewHelper
	extends Tx_Fluid_ViewHelpers_IfViewHelper {

	/**
	 * @param mixed $person The person to be tested for login
	 * @return string The output
	 */
	public function render($person = NULL) {
		$accessControlService = t3lib_div::makeInstance('Tx_HelfenKannJeder_Service_AccessControlService'); // Singleton
		if ($accessControlService->isLoggedIn($person)) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}
?>
