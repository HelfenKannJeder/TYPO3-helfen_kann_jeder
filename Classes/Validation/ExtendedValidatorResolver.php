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
namespace Querformatik\HelfenKannJeder\Validation;
/* 
 * @author Sebastian Kurfürst
 */
class ExtendedValidatorResolver extends \TYPO3\CMS\Extbase\Validation\ValidatorResolver {
	/**
	 * Builds a base validator conjunction for the given data type.
	 *
	 * The base validation rules are those which were declared directly in a class (typically
	 * a model) through some @validate annotations on properties.
	 * It will only validate the properties which are sent with the current request.
	 *
	 *
	 * @param string $dataType The data type to build the validation conjunction for. Needs to be the fully qualified object name.
	 * @return \TYPO3\CMS\Extbase\Validation\Validator\ConjunctionValidator The validator conjunction or NULL
	 */
	public function buildBaseValidatorConjunctionWithRequestData($dataType, $rawRequest) {
		// Model based validator
		// This method looks almost exactly like "buildBaseValidatorConjunction" in ValidatorResolver.
		if (strstr($dataType, '_') !== FALSE && class_exists($dataType)) {
			$objectValidator = $this->createValidator('GenericObject');

			$validatorCount = 0;

			foreach ($this->reflectionService->getClassPropertyNames($dataType) as $classPropertyName) {
				$classPropertyTagsValues = $this->reflectionService->getPropertyTagsValues($dataType, $classPropertyName);
				if (!isset($classPropertyTagsValues['validate'])) continue;
				// This is the only real change to the ValidatorResolver: We only add the
				// validation for a property if this property has been changed in the current request.
				if (!is_array($rawRequest) || !isset($rawRequest[$classPropertyName])) continue;

				foreach ($classPropertyTagsValues['validate'] as $validateValue) {
					$parsedAnnotation = $this->parseValidatorAnnotation($validateValue);
					foreach ($parsedAnnotation['validators'] as $validatorConfiguration) {
						$newValidator = $this->createValidator($validatorConfiguration['validatorName'], $validatorConfiguration['validatorOptions']);
						if ($newValidator === NULL) {
							throw new \TYPO3\CMS\Extbase\Validation\Exception\NoSuchValidatorException('Invalid validate annotation in ' . $dataType . '::' . $classPropertyName . ': Could not resolve class name for  validator "' . $validatorConfiguration['validatorName'] . '".', 1241098027);
						}
						$objectValidator->addPropertyValidator($classPropertyName, $newValidator);
						$validatorCount ++;
					}
				}
			}
			if ($validatorCount > 0) return $objectValidator;
		}
		return $this->createValidator('Conjunction'); // Just a validator returning TRUE; in case no validation needs to take place.
		
	}
}
?>
