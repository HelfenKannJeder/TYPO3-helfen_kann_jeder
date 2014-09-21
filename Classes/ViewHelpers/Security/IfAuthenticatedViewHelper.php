<?php
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
