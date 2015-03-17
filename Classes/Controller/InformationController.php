<?php
namespace Querformatik\HelfenKannJeder\Controller;

/**
 * Displays information for organisations or other users.
 *
 * @author Valentin Zickner
 */
class InformationController extends AbstractOrganisationController {

	/**
	 * organisationDraftRepository
	 *
	 * @var \Querformatik\HelfenKannJeder\Domain\Repository\OrganisationDraftRepository
	 * @inject
	 */
	protected $draftRepository;

	/**
	 * accessControlService
	 *
	 * @var \Querformatik\HelfenKannJeder\Service\AccessControlService
	 * @inject
	 */
	protected $accessControlService;

	/**
	 * Get the first supporter for the current, logged in, organisation
	 *
	 * @return void
	 */
	public function organisationAction() {
		$frontendUser = $this->accessControlService->getFrontendUser();
		if ($frontendUser != NULL) {
			$organisation = $this->draftRepository->findByFeuser($frontendUser->getUid())->getFirst();
		}
		$this->view->assign('organisation', $organisation);
	}

	/**
	 * Get information about currently logged in user
	 *
	 * @return void
	 */
	public function loggedInAction() {
		$frontendUser = $this->accessControlService->getFrontendUser();
		$this->view->assign('frontendUser', $frontendUser);
	}


	/**
	 * Get information about user location
	 *
	 * @return void
	 */
	public function mapAction() {
	}

}
