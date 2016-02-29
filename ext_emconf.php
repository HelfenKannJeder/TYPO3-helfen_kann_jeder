<?php
/*
 * Copyright (C) 2016 Valentin Zickner <valentin.zickner@helfenkannjeder.de>
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

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Helfen Kann Jeder',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Valentin Zickner',
	'author_company' => 'HelfenKannJeder e.V.',
	'author_email' => 'valentin.zickner@helfenkannjeder.de',
	'state' => 'stable',
	'clearCacheOnLoad' => 1,
	'version' => '2.1.1-dev',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-0.0.0',
			'extbase' => '1.0.0-0.0.0',
			'fluid' => '1.0.0-0.0.0',
			'mvc_extjs' => '0.1.1-0.0.0',
			'pagepath' => '0.0.0',
			'coreapi' => '0.0.0',
			'vhs' => '2.3.1',
			'qu_base' => '0.0.0',
			'sr_freecap' => '2.0.5-0.0.0',
			't3jquery' => '2.7.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'conflicts' => ''
);

?>
