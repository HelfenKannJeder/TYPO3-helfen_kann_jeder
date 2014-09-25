<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TCA['tx_helfenkannjeder_domain_model_organisationtype'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_organisationtype']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, description, picture, teaser, registerable, hide_in_result, dummy_organisation',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisationtype',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_organisationtype.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_organisationtype.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'namedisplay' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.namedisplay',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'acronym' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.acronym',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'picture' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.picture',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'png',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/pics/',
				'show_thumbs' => 1,
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 1,
				'autoSizeMax' => 10,
			),
		),
		'teaser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.teaser',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'png,jpg',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/pics/',
				'show_thumbs' => 1,
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 10,
				'autoSizeMax' => 10,
			),
		),
		'logos' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.logos',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'png',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/tx_helfenkannjeder/',
				'show_thumbs' => 1,
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 10,
				'autoSizeMax' => 10,
			),
		),
		'pseudo' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.pseudo',
			'config' => array(
				'type' => 'check'
			)
		),
		'group_template_categories' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.grouptemplatecategories',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_grouptemplatecategory',
				'foreign_field' => 'organisationtype',
//				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_workinghour.day',
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'fegroup' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.group',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_Extbase_Domain_Model_FrontendUserGroup',
				'foreign_table' => 'fe_groups',
				'foreign_table_where' => 'AND fe_groups.tx_extbase_type="Tx_Extbase_Domain_Model_FrontendUserGroup"',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'registerable' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.registerable',
			'config' => array(
				'type' => 'check'
			)
		),
		'hide_in_result' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.hide_in_result',
			'config' => array(
				'type' => 'check'
			)
		),
		'dummy_organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype.dummy_organisation',
			'config' => array(
				'type' => 'select',
				'foreign_class' => '\\Querformatik\\HelfenKannJeder\\Domain\\Model\\Organisation',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_organisation.is_dummy=1',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, name, namedisplay, acronym, description, picture, teaser, logos, group_template_categories, pseudo, fegroup, registerable, hide_in_result, dummy_organisation')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>
