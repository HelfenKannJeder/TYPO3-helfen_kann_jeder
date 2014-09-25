<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.user',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'timestamp' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.timestamp',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'type' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.type.type.0', '0'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoPersonaldata', 'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoPersonaldata'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoActivitysearch', 'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoActivitysearch'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoActivity', 'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoActivity'),
					array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.type.Tx_HelfenKannJeder_Domain_Model_UserdoActivityfield', 'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoActivityfield'),
				),
				'size' => 1,
				'maxitems' => 1,
				'default' => '0'
			)
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.address',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.longitude',
			'config' => array(
				'type' => 'none',
				'size' => 10,
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.latitude',
			'config' => array(
				'type' => 'none',
				'size' => 10,
			)
		),
		'response' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.response',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.age',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'input' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.input',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'result' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.result',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'activity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.activity',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'activityfield' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.activityfield',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_userdo.status',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'user, timestamp, type'),
		'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoPersonaldata' => array('showitem' => 'user, timestamp, type, address, street, city, zipcode, longitude, latitude, response, age'),
		'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoActivitysearch' => array('showitem' => 'user, timestamp, type, input, result'),
		'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoActivity' => array('showitem' => 'user, timestamp, type, activity, status'),
		'Querformatik\\HelfenKannJeder\\Domain\\Model\\UserdoActivityfield' => array('showitem' => 'user, timestamp, type, activityfield, status'),
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>
