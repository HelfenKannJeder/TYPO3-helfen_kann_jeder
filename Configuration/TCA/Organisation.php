<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TCA['tx_helfenkannjeder_domain_model_organisation'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_organisation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'crdate, tstamp, name, description, website, street, city, zipcode, longitude, latitude, contact_person, picture, feuser, remind_last, remind_count, is_dummy',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.crdate',
			'config' => array(
				'type' => 'none'
			)
		),
		'tstamp' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.tstamp',
			'config' => array(
				'type' => 'none'
			)
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'organisationtype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.type',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'umbrellaorganisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.umbrellaorganisation',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'nationalassociation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.nationalassociation',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'addressappendix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.addressappendix',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.longitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.latitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'telephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
/*		'mobilephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.mobilephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),*/
		'defaultaddress' => array( // TODO
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.defaultaddress',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_address',
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
				'items' => array(
					array('---', 0),
				),
			)
		),
		'addresses' => array( // TODO
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.addresses',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.logo',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.pictures',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.feuser',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.activityfieldlayers',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activityfieldlayer',
				'foreign_field' => 'organisation',
			)
		),*/
		'groups' => array( // TODO
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.groups',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.workinghours',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.contactpersons',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.contactperson',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.employees',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_employee',
				'foreign_field' => 'organisation',
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_employee.prename',
			)
		),
		'matrices' => array( // TODO
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.matrices',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_matrix',
				'foreign_field' => 'organisation',
			)
		),
		'request' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.request',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.request.0', 0),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.request.1', 1),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.request.2', 2),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.request.3', 3),
				),
				'wizards' => array(
				),
				'suppress_icons' => 1,
			)
		),
		'requesttime' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.requesttime',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => '',
			)
		),
		'supporter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.supporter',
			'config' => array(
				'type' => 'select',
				'foreign_class' => '\\Querformatik\\HelfenKannJeder\\Domain\\Model\\Supporter',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.tx_extbase_type="Querformatik\\HelfenKannJeder\\Domain\\Model\\Supporter"',
				'items' => array(
					array('---', 0),
				),
				'wizards' => array(),
				'suppress_icons' => 1,
			)
		),
		'hash' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.hash',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.reference',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.remind_last',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => '',
			)
		),
		'remind_count' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.remind_count',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'is_dummy' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation.is_dummy',
			'config' => array(
				'type' => 'check'
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, crdate, tstamp, name, description, organisationtype, website, street, city, zipcode, umbrellaorganisation, nationalassociation, addressappendix, longitude, latitude, telephone, defaultaddress, addresses, logo, pictures, feuser, groups, employees, contactpersons, workinghours, reference, hash, is_dummy')
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
?>
