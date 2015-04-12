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

########################################################################
# Extension Manager/Repository config file for ext "helfen_kann_jeder".
#
# Auto generated 16-09-2012 22:53
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Helfen Kann Jeder',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Valentin Zickner',
	'author_company' => 'Querformatik UG (haftungsbeschraenkt) and Technisches Hilfswerk Karlsruhe',
	'author_email' => 'zickner@querformatik.de',
	'dependencies' => 'extbase,fluid,captcha_viewhelper,coreapi,vhs',
	'state' => 'stable',
	'clearCacheOnLoad' => 1,
	'version' => '2.1.1-dev',
	'contraints' => array(
		'depends' => array(
			'typo3' => '4.3.0-4.5.99',
			'extbase' => '1.0.0-0.0.0',
			'fluid' => '1.0.0-0.0.0',
			'mvc_extjs' => '0.1.1-0.0.0',
			'captcha_viewhelper' => '0.0.0',
			'pagepath' => '0.0.0',
			'coreapi' => '0.0.0',
			'vhs' => '2.3.1',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'conflicts' => '',
	'constraints' => array(
		'depends' => array(
			'extbase' => '',
			'fluid' => '',
			'captcha_viewhelper' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>
