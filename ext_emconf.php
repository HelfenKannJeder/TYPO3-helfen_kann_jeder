<?php

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
	'version' => '2.1.0',
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
