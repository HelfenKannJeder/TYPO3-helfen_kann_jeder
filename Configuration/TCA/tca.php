<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TCA['tx_helfenkannjeder_domain_model_organisationtype'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_organisationtype']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, description, picture, teaser, registerable, hide_in_result',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'namedisplay' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.namedisplay',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'acronym' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.acronym',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'picture' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.picture',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.teaser',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.logos',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.pseudo',
			'config' => array(
				'type' => 'check'
			)
		),
		'group_template_categories' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.grouptemplatecategories',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.group',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.registerable',
			'config' => array(
				'type' => 'check'
			)
		),
		'hide_in_result' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.hide_in_result',
			'config' => array(
				'type' => 'check'
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, name, namedisplay, acronym, description, picture, teaser, logos, group_template_categories, pseudo, fegroup, registerable, hide_in_result')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_helfenkannjeder_domain_model_organisation'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_organisation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'crdate, tstamp, name, description, website, street, city, zipcode, longitude, latitude, contact_person, picture, feuser, remind_last, remind_count',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_organisation.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_organisation.sys_language_uid IN (-1, 0)',
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
		'crdate' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.crdate',
			'config' => array(
				'type' => 'none'
			)
		),
		'tstamp' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.tstamp',
			'config' => array(
				'type' => 'none'
			)
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'organisationtype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.type',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisationtype',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'website' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'umbrellaorganisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.umbrellaorganisation',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'nationalassociation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.nationalassociation',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'addressappendix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.addressappendix',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.longitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.latitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'telephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
/*		'mobilephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.mobilephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),*/
		'defaultaddress' => array( // TODO
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.defaultaddress',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'addresses' => array( // TODO
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.addresses',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'foreign_field' => 'organisation',
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'logo' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.logo',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,jpg,png',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/tx_helfenkannjeder/',
				'show_thumbs' => 1,
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 1,
				'autoSizeMax' => 1,
			),
		),
		'pictures' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.pictures',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,jpg,png',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/tx_helfenkannjeder',
				'show_thumbs' => 1,
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 200,
				'autoSizeMax' => 10,
			),
		),
		'feuser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.feuser',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_Extbase_Domain_Model_FrontendUser',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.tx_extbase_type="Tx_Extbase_Domain_Model_FrontendUser"',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
/*					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'fe_users',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
					),*/
				),
				'suppress_icons' => 1,
			)
		),
/*		'activityfieldlayers' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.activityfieldlayers',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activityfieldlayer',
				'foreign_field' => 'organisation',
			)
		),*/
		'groups' => array( // TODO
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.groups',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_group',
				'foreign_field' => 'organisation',
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_group.name',
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'workinghours' => array( // TODO
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.workinghours',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_workinghour',
				'foreign_field' => 'organisation',
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_workinghour.day',
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'contactpersons' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.contactpersons',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_employee.organisation = ###REC_FIELD_uid### ORDER BY tx_helfenkannjeder_domain_model_employee.prename',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_employee',
				'MM' => 'tx_helfenkannjeder_organisaton_contactperson_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
/*		'contactperson' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.contactperson',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_employee',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),*/
		'employees' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.employees',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_employee',
				'foreign_field' => 'organisation',
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_employee.prename',
			)
		),
		'matrices' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.matrices',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_field' => 'organisation',
			)
		),
		'request' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.request',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.request.0', 0),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.request.1', 1),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.request.2', 2),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.request.3', 3),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'requesttime' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.requesttime',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => '',
			)
		),
		'supporter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.supporter',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_HelfenKannJeder_Domain_Model_Supporter',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.tx_extbase_type="Tx_HelfenKannJeder_Domain_Model_Supporter"',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'hash' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.hash',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.reference',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisationdraft',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'remind_last' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.remind_last',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => '',
			)
		),
		'remind_count' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisation.remind_count',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, crdate, tstamp, name, description, organisationtype, website, street, city, zipcode, umbrellaorganisation, nationalassociation, addressappendix, longitude, latitude, telephone, defaultaddress, addresses, logo, pictures, feuser, groups, employees, contactpersons, workinghours, reference, hash')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$organisationDraftCtrl = $TCA['tx_helfenkannjeder_domain_model_organisationdraft']['ctrl'];
$TCA['tx_helfenkannjeder_domain_model_organisationdraft'] = $TCA['tx_helfenkannjeder_domain_model_organisation'];
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['ctrl'] = $organisationDraftCtrl;
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['groups']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_groupdraft';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['groups']['config']['foreign_table_where'] = 'ORDER BY tx_helfenkannjeder_domain_model_groupdraft.name';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['defaultaddress']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_addressdraft';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['addresses']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_addressdraft';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['contactpersons']['config']['foreign_table_where'] =
		 'AND tx_helfenkannjeder_domain_model_employeedraft.organisation = ###REC_FIELD_uid### ORDER BY tx_helfenkannjeder_domain_model_employeedraft.prename';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['contactpersons']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_employeedraft';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['contactpersons']['config']['MM'] = 'tx_helfenkannjeder_organisatondraft_contactperson_mm';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['employees']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_employeedraft';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['employees']['config']['foreign_table_where'] = 'ORDER BY tx_helfenkannjeder_domain_model_employeedraft.prename';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['workinghours']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_workinghourdraft';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['workinghours']['config']['foreign_table_where'] = 'ORDER BY tx_helfenkannjeder_domain_model_workinghourdraft.day';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['columns']['reference']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_organisation';
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['types']['1']['showitem'] .= ', supporter, request, requesttime, remind_last, remind_count';

$TCA['tx_helfenkannjeder_domain_model_group'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_group']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, description, website, minimum_age, maximum_age, matrix, street, city, zipcode, longitude, latitude, organisation, template, sort',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_group',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_group.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_group.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'workinghours' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.workinghours',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'website' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'minimum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.minimum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'maximum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.maximum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'matrix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.matrix',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.longitude',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'double2',
				'max' => 255
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.latitude',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'double2',
				'max' => 255
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.organisation',
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
		'template' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.grouptemplate',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_grouptemplate',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				)
			)
		),
		'contactpersons' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.contactpersons',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_employee.organisation = ###REC_FIELD_organisation### ORDER BY tx_helfenkannjeder_domain_model_employee.prename',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_employee',
				'MM' => 'tx_helfenkannjeder_group_contactperson_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_group.reference',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_groupdraft',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'sort' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'name, description, website, minimum_age, maximum_age, contactpersons, matrix, organisation, reference, template, sort')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$groupDraftCtrl = $TCA['tx_helfenkannjeder_domain_model_groupdraft']['ctrl'];
$TCA['tx_helfenkannjeder_domain_model_groupdraft'] = $TCA['tx_helfenkannjeder_domain_model_group'];
$TCA['tx_helfenkannjeder_domain_model_groupdraft']['ctrl'] = $groupDraftCtrl;
$TCA['tx_helfenkannjeder_domain_model_groupdraft']['columns']['contactpersons']['config']['foreign_table_where'] =
		 'AND tx_helfenkannjeder_domain_model_employeedraft.organisation = ###REC_FIELD_organisation### ORDER BY tx_helfenkannjeder_domain_model_employeedraft.prename';
$TCA['tx_helfenkannjeder_domain_model_groupdraft']['columns']['contactpersons']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_employeedraft';
$TCA['tx_helfenkannjeder_domain_model_groupdraft']['columns']['contactpersons']['config']['MM'] = 'tx_helfenkannjeder_groupdraft_contactperson_mm';
$TCA['tx_helfenkannjeder_domain_model_groupdraft']['columns']['reference']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_group';
//$TCA['tx_helfenkannjeder_domain_model_groupdraft']['types']['1']['showitem'] .= ', template';

$TCA['tx_helfenkannjeder_domain_model_grouptemplatecategory'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_grouptemplatecategory']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'organisationtype, name, description, sort',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_grouptemplatecategory',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_grouptemplatecategory.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_grouptemplatecategory.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplatecategory.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplatecategory.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'organisationtype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplatecategory.organisationtype',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisationtype',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				)
			)
		),
		'group_templates' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplatecategory.grouptemplates',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_grouptemplate',
				'foreign_field' => 'grouptemplatecategory',
//				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_workinghour.day',
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'sort' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'name, description, organisationtype, group_templates, sort')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_helfenkannjeder_domain_model_grouptemplate'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_grouptemplate']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, description, group_of_group_templategroup_of_group_template, minimum_age, maximum_age, matrix, grouptemplatecategory, sort',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_grouptemplate',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_grouptemplate.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_grouptemplate.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'suggestion' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.suggestion',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'minimum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.minimum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'maximum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.maximum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'matrix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.matrix',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'grouptemplatecategory' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.grouptemplatecategory',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_grouptemplatecategory',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				)
			)
		),
		'group_of_group_template' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.group_of_group_template',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_groupofgrouptemplate',
				'foreign_table_where' => ' ORDER BY tx_helfenkannjeder_domain_model_groupofgrouptemplate.name ASC ',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				)
			)
		),
		'isdefault' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.isdefault',
			'config' => array(
				'type' => 'check'
			)
		),
		'isoptional' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.isoptional',
			'config' => array(
				'type' => 'check'
			)
		),
		'isfeature' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_grouptemplate.isfeature',
			'config' => array(
				'type' => 'check'
			)
		),
		'sort' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'name, description, group_of_group_template, suggestion, minimum_age, maximum_age, isdefault, isoptional, isfeature, matrix, grouptemplatecategory, sort')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfield.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfield.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'activities' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfield.activities',
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

/*$TCA['tx_helfenkannjeder_domain_model_activityfieldlayer'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_activityfieldlayer']['ctrl'],
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activityfieldlayer',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_activityfieldlayer.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_activityfieldlayer.sys_language_uid IN (-1, 0)',
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
		'activityfield' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfieldlayer.activityfield',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activityfield',
				'foreign_table_where' => '',
				'items' => array(
					array('---', ''),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfieldlayer.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_helfenkannjeder_domain_model_organisation',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
					),
				),
				'suppress_icons' => 1,
			)
		),
		'grade' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfieldlayer.grade',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfieldlayer.grade.step0', 0),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activityfieldlayer.grade.step1', 1),
				),
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'activityfield, organisation, grade'),
		'1' => array('showitem' => 'sys_language_uid, hidden. activityfield, organisation, grade'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);*/

$TCA['tx_helfenkannjeder_domain_model_activity'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_activity']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, description',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_activity.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_activity.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activity.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activity.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'keywords' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activity.keywords',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 30 
			)
		),
		'words' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_activity.words',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_word',
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
		'0' => array('showitem' => 'name, description, keywords'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);

$TCA['tx_helfenkannjeder_domain_model_employee'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_employee']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'surname',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_employee',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_employee.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_employee.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_helfenkannjeder_domain_model_organisation',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
					),
				),
				'suppress_icons' => 1,
			)
		),
		'iscontact' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.is_contact',
			'config' => array(
				'type' => 'passthrough',
			)
		),
		'rank' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.rank',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'surname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.surname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'prename' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.prename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'teaser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.teaser',
			'config' => array(
				'type' => 'input',
				'size' => 160,
				'eval' => 'trim',
				'max' => 160
			)
		),
		'headline' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.headline',
			'config' => array(
				'type' => 'input',
				'size' => 160,
				'eval' => 'trim',
				'max' => 160
			)
		),
		'motivation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.motivation',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'birthday' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.birthday',
			'config' => array(
				'type' => 'input',
				'size' => 8,
				'checkbox' => '',
				'eval' => 'date',
			)
		),
		'pictures' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.pictures',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,jpg,png',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/pics/',
				'show_thumbs' => 1,
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 200,
				'autoSizeMax' => 10,
			),
		),
		'mail' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.mail',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'telephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'mobilephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.mobilephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_employee.reference',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_employeedraft',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
// TODO bilder, kontaktdaten
	),
	'types' => array(
		'0' => array('showitem' => 'activityfield, organisation, rank, surname, prename, teaser, headline, motivation, birthday, pictures, mail, telephone, mobilephone, iscontact, reference'),
		'1' => array('showitem' => 'sys_language_uid, hidden, activityfield, organisation, rank, surname, prename, teaser, headline, motivation, birthday, pictures, mail, street, city, reference'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);
$employeeDraftCtrl = $TCA['tx_helfenkannjeder_domain_model_employeedraft']['ctrl'];
$TCA['tx_helfenkannjeder_domain_model_employeedraft'] = $TCA['tx_helfenkannjeder_domain_model_employee'];
$TCA['tx_helfenkannjeder_domain_model_employeedraft']['ctrl'] = $employeeDraftCtrl;
$TCA['tx_helfenkannjeder_domain_model_employeedraft']['columns']['organisation']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_organisationdraft';
$TCA['tx_helfenkannjeder_domain_model_employeedraft']['columns']['reference']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_employee';
/*
$TCA['tx_helfenkannjeder_domain_model_interested_person'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_interested_person']['ctrl'],
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_interested_person',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_interested_person.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_interested_person.sys_language_uid IN (-1, 0)',
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
		'organisations' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_interested_person.organisation',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'MM' => 'tx_helfenkannjeder_interested_person_organisation_mm',
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'activities' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_interested_person.activities',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'MM' => 'tx_helfenkannjeder_interested_person_activity_mm',
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'ip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_interested_person.ip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'sessionid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_interested_person.sessionid',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'last_activity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_interested_person.last_activity',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => '',
			)
		),
		'age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_interested_person.age',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'num',
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_interested_person.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'organisations, activities, ip, sessionid, last_activity, age, city'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);*/

$TCA['tx_helfenkannjeder_domain_model_matrixfield'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_matrixfield']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'matrix, organisation, activity, activityfield, grade',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrixfield',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_matrixfield.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_matrixfield.sys_language_uid IN (-1, 0)',
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
		'matrix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrixfield.matrix',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrixfield.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'activity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrixfield.activity',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'activityfield' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrixfield.activityfield',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activityfield',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'grade' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrixfield.grade',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrixfield.grade.step0', 1),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrixfield.grade.step1', 2),
				),
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'matrix, organisation, activity, activityfield, grade'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);

$TCA['tx_helfenkannjeder_domain_model_matrix'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_matrix']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, organisation, feuser, matrixfields',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_matrix.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_matrix.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrix.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrix.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'feuser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrix.feuser',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_Extbase_Domain_Model_FrontendUser',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.tx_extbase_type="Tx_Extbase_Domain_Model_FrontendUser"',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'fe_users',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
					),
				),
				'suppress_icons' => 1,
			)
		),
		'matrixfields' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_matrix.matrixfields',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrixfield',
				'foreign_field' => 'matrix',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'name, organisation, feuser, matrixfields'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);

$TCA['tx_helfenkannjeder_domain_model_word'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_word']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'word, wordparts, activity',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_matrix.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_matrix.sys_language_uid IN (-1, 0)',
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
		'word' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_word.word',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
//		'wordparts' => array(
//			'exclude' => 0,
//			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_word.wordparts',
//			'config' => array(
/*				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,*/
//			)
//		),
		'activity' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_word.activity',
			'config' => array(
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'word, activity'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);

/*$TCA['tx_helfenkannjeder_domain_model_wordpart'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_wordpart']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'word, part, position, complete',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_matrix.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_matrix.sys_language_uid IN (-1, 0)',
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
		'word' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_word.word',
			'config' => array(
			)
		),
		'part' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_word.part',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'position' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_word.position',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'complete' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_word.complete',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'word, part, position, complete'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);*/

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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
/*					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'organisation',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
					),*/
				)
			)
		),
		'day' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('---', 0),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day.monday', 1),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day.tuesday', 2),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day.wednesday', 3),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day.thursday', 4),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day.friday', 5),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day.saturday', 6),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.day.sunday', 7),
				),
			)
		),
		'starttimehour' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.starttimehour',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'starttimeminute' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.starttimeminute',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'stoptimehour' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.stoptimehour',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'stoptimeminute' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.stoptimeminute',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
			)
		),
		'addition' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.addition',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'groups' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.groups',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.address',
			'config' => array(
				'type' => 'select',
				'foreign_table_where' => '',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'wizards' => array(
				),
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.address.none_special',0)
				),
				'suppress_icons' => 1,
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_workinghour.reference',
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

$TCA['tx_helfenkannjeder_domain_model_address'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_address']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'street, city, zipcode, longitude, latitude, telephone, website',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_address.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_address.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisation',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'organisation',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
					),
				)
			)
		),
		'addressappendix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.addressappendix',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.longitude',
			'config' => array(
				'type' => 'passthrough',
				'size' => 10,
				'eval' => '',
				'max' => 255
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.latitude',
			'config' => array(
				'type' => 'passthrough',
				'size' => 10,
				'eval' => '',
				'max' => 255
			)
		),
		'telephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.reference',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_addressdraft',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'website' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_address.website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'organisation, addressappendix, street, city, zipcode, longitude, latitude, telephone, website, reference')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
$addressDraftCtrl = $TCA['tx_helfenkannjeder_domain_model_addressdraft']['ctrl'];
$TCA['tx_helfenkannjeder_domain_model_addressdraft'] = $TCA['tx_helfenkannjeder_domain_model_address'];
$TCA['tx_helfenkannjeder_domain_model_addressdraft']['ctrl'] = $addressDraftCtrl;
$TCA['tx_helfenkannjeder_domain_model_addressdraft']['columns']['organisation']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_organisationdraft';
$TCA['tx_helfenkannjeder_domain_model_addressdraft']['columns']['reference']['config']['foreign_table'] = 'tx_helfenkannjeder_domain_model_address';

$TCA['tx_helfenkannjeder_domain_model_user'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_user']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'session, lastactivity, browser, actions',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_address.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_address.sys_language_uid IN (-1, 0)',
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
		'session' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_user.session',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'lastactivity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_user.lastactivity',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'ip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_user.ip',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'browser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_user.browser',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'actions' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_user.actions',
			'config' => array(
				'type' => 'none',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'session, lastactivity, browser, actions')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_helfenkannjeder_domain_model_userdo'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_userdo']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_address.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_address.sys_language_uid IN (-1, 0)',
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
		'user' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.user',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'timestamp' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.timestamp',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'type' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.type.type.0', '0'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoPersonaldata', 'Tx_HelfenKannJeder_Domain_Model_UserdoPersonaldata'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoActivitysearch', 'Tx_HelfenKannJeder_Domain_Model_UserdoActivitysearch'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoActivity', 'Tx_HelfenKannJeder_Domain_Model_UserdoActivity'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoActivityfield', 'Tx_HelfenKannJeder_Domain_Model_UserdoActivityfield'),
				),
				'size' => 1,
				'maxitems' => 1,
				'default' => '0'
			)
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.address',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.longitude',
			'config' => array(
				'type' => 'none',
				'size' => 10,
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.latitude',
			'config' => array(
				'type' => 'none',
				'size' => 10,
			)
		),
		'response' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.response',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.age',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'input' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.input',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'result' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.result',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'activity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.activity',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'activityfield' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.activityfield',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_userdo.status',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'user, timestamp, type'),
		'Tx_HelfenKannJeder_Domain_Model_UserdoPersonaldata' => array('showitem' => 'user, timestamp, type, address, street, city, zipcode, longitude, latitude, response, age'),
		'Tx_HelfenKannJeder_Domain_Model_UserdoActivitysearch' => array('showitem' => 'user, timestamp, type, input, result'),
		'Tx_HelfenKannJeder_Domain_Model_UserdoActivity' => array('showitem' => 'user, timestamp, type, activity, status'),
		'Tx_HelfenKannJeder_Domain_Model_UserdoActivityfield' => array('showitem' => 'user, timestamp, type, activityfield, status'),
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_helfenkannjeder_domain_model_backer'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_backer']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_backer',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_backer.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_backer.sys_language_uid IN (-1, 0)',
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
		'degree' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.degree',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'prename' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.prename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'surname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.surname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'company' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.company',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.status',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'thumbnail' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.thumbnail',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'png,jpg',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/pics/',
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 1,
				'maxitems' => 1,
				'autoSizeMax' => 10,
			),
		),
		'picture' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_organisationtype.picture',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'png,jpg',
				'max_size' => 10000,
				'uploadfolder' => 'uploads/pics/',
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 1,
				'maxitems' => 1,
				'autoSizeMax' => 10,
			),
		),
		'type' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.type.0', '0'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.type.1', '1'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.type.2', '2'),
				),
				'size' => 1,
				'maxitems' => 1,
				'default' => '0'
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.description',
			'config' => array(
				'type' => 'text',
				'size' => 30,
			)
		),
		'since' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_backer.since',
			'config' => array(
				'type' => 'input',
				'size' => 8,
				'checkbox' => '',
				'eval' => 'date',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'degree, prename, surname, company, status, thumbnail, picture, type, description, since'),
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_helfenkannjeder_domain_model_registerorganisationprogress'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_registerorganisationprogress']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_registerorganisationprogress',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_registerorganisationprogress.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_registerorganisationprogress.sys_language_uid IN (-1, 0)',
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
		'crdate' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.crdate',
			'config' => array(
				'type' => 'none'
			)
		),
		'modified' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.modified',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'datetime'
			)
		),
		'sessionid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.sessionid',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'agreement' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.agreement',
			'config' => array(
				'type' => 'check',
			)
		),
		'organisationtype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.organisationtype',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisationtype',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'typename' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.typename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'typeacronym' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.typeacronym',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'typedescription' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.typedescription',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.longitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.latitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'department' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.department',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'organisationname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.organisationname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'username' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.username',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'password' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.password',
			'config' => array(
				'type' => 'passthrough',
				'size' => 30,
				'eval' => 'md5',
				'max' => 255
			)
		),
		'password2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.password2',
			'config' => array(
				'type' => 'passthrough',
				'size' => 30,
				'eval' => 'md5',
				'max' => 255
			)
		),
		'password_saved' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.password_saved',
			'config' => array(
				'type' => 'check',
			)
		),
		'mail' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.mail',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'feuser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.feuser',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_Extbase_Domain_Model_FrontendUser',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.tx_extbase_type="Tx_Extbase_Domain_Model_FrontendUser"',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisationdraft',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array()
			)
		),
		'laststep' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.laststep',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int',
			)
		),
		'finisheduntil' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.finisheduntil',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int',
			)
		),
		'mail_hash' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.mail_hash',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'supporter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.supporter',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_HelfenKannJeder_Domain_Model_Supporter',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.tx_extbase_type="Tx_HelfenKannJeder_Domain_Model_Supporter"',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'prename' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.prename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'surname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_registerorganisationprogress.surname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'created, modified, sessionid, agreement, organisationtype, typename, typeacronym, typedescription, city, latitude, longitude, department, organisationname, username, password, password2, password_saved, mail, feuser, organisation, laststep, finisheduntil, mail_hash, supporter, surname, prename'),
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_helfenkannjeder_domain_model_log'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_log']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_log',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_log.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_log.sys_language_uid IN (-1, 0)',
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
		'crdate' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_log.crdate',
			'config' => array(
				'type' => 'none'
			)
		),
		'feuser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_log.feuser',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_Extbase_Domain_Model_FrontendUser',
				'foreign_table' => 'fe_users',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_log.organisation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_organisationdraft',
				'foreign_table_where' => '',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array()
			)
		),
		'message' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xml:tx_helfenkannjeder_domain_model_log.message',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'crdate, feuser, organisation, message'),
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>
