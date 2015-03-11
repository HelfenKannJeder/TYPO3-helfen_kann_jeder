<?php
namespace Querformatik\HelfenKannJeder\Domain\Repository;

/**
 * Find and modify organisations
 *
 * @author Valentin Zickner
 */
class OrganisationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	protected $defaultOrderings = array('name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);

	public function findOrganisationNearLocation($latitude, $longitude, $dummys = TRUE) {
		$query = $this->createQuery();

		$location = $query->logicalAnd(
					$query->greaterThanOrEqual('latitude', $latitude - 0.5),
					$query->lessThanOrEqual('latitude', $latitude + 0.5),
					$query->greaterThanOrEqual('longitude', $longitude - 0.5),
					$query->lessThanOrEqual('longitude', $longitude + 0.5)
				);

		if ($dummys) {
			return $query->matching($query->logicalOr($location, $query->equals('isDummy', 1)))->execute();
		} else {
			return $query->matching($location)->execute();
		}
	}


}
