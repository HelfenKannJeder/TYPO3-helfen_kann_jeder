<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TCA['tx_helfenkannjeder_domain_model_workinghour'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_workinghour']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'organisation, day, starttimehour, stoptimehour, starttimeminute, stoptimeminute, groups, addition, address',
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_helfenkannjeder_domain_model_workinghour',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_workinghour.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_workinghour.sys_language_uid IN (-1, 0)',
			)
		),
		'l18n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type' => 'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check'
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				)
			)
		),
		'day' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('---', 0),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day.monday', 1),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day.tuesday', 2),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day.wednesday', 3),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day.thursday', 4),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day.friday', 5),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day.saturday', 6),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.day.sunday', 7),
				),
			)
		),
		'starttimehour' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.starttimehour',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'starttimeminute' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.starttimeminute',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'stoptimehour' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.stoptimehour',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'stoptimeminute' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.stoptimeminute',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'addition' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.addition',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'groups' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.groups',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_group.organisation = ###REC_FIELD_organisation### ORDER BY tx_helfenkannjeder_domain_model_group.sort',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_group',
				'MM' => 'tx_helfenkannjeder_workinghour_group_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.address',
			'config' => array(
				'type' => 'select',
				'foreign_table_where' => '',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'wizards' => array(
				),
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.address.none_special',0)
				),
				'suppress_icons' => 1,
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour.reference',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_workinghourdraft',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'organisation, day, starttimehour, starttimeminute, stoptimehour, stoptimeminute, addition, groups, address, reference')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
$workinghourDraftCtrl = $TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['ctrl'];
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft'] = $TCA['tx_helfenkannjeder_domain_model_workinghour'];
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['ctrl'] = $workinghourDraftCtrl;
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['columns']['organisation']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_organisationdraft';
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['columns']['groups']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_groupdraft';
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['columns']['groups']['config']['foreign_table_where'] = 'AND tx_helfenkannjeder_domain_model_groupdraft.organisation = ###REC_FIELD_organisation### ORDER BY tx_helfenkannjeder_domain_model_groupdraft.sort';
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['columns']['groups']['config']['MM'] = 'tx_helfenkannjeder_workinghourdraft_groupdraft_mm';
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['columns']['address']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_addressdraft';
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['columns']['address']['config']['foreign_table_where'] = 'AND tx_helfenkannjeder_domain_model_addressdraft.organisation = ###REC_FIELD_organisation### ORDER BY tx_helfenkannjeder_domain_model_addressdraft.sort';
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['columns']['reference']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_workinghour';
?>
