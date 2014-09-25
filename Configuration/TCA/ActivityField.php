<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TCA['tx_helfenkannjeder_domain_model_activityfield'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_activityfield']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activityfield',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_activityfield.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_activityfield.sys_language_uid IN (-1, 0)',
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
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_activityfield.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_activityfield.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'activities' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_activityfield.activities',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_activity.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'MM' => 'tx_helfenkannjeder_activityfield_activity_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, name, description, activities')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>
