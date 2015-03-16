<?php
namespace Querformatik\HelfenKannJeder\Tests\Unit\Fixtures;

/**
 * Fixture for OrganisationSearchService
 *
 * @author Valentin Zickner
 */
class OrganisationSearchService extends \Querformatik\HelfenKannJeder\Service\OrganisationSearchService {
	public function buildOrganisationInfo($organisation, $grade, $distance, $uriBuilder) {
		return parent::buildOrganisationInfo($organisation, $grade, $distance, $uriBuilder);
	}
}
