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
if (!defined ('TYPO3_MODE')) die ('Access denied.');

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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.crdate',
			'config' => array(
				'type' => 'none'
			)
		),
		'modified' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.modified',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'datetime'
			)
		),
		'sessionid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.sessionid',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'agreement' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.agreement',
			'config' => array(
				'type' => 'check',
			)
		),
		'organisationtype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.organisationtype',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.typename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'typeacronym' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.typeacronym',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'typedescription' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.typedescription',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.longitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.latitude',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			)
		),
		'department' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.department',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'organisationname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.organisationname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'username' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.username',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'password' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.password',
			'config' => array(
				'type' => 'passthrough',
				'size' => 30,
				'eval' => 'md5',
				'max' => 255
			)
		),
		'password2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.password2',
			'config' => array(
				'type' => 'passthrough',
				'size' => 30,
				'eval' => 'md5',
				'max' => 255
			)
		),
		'password_saved' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.password_saved',
			'config' => array(
				'type' => 'check',
			)
		),
		'mail' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.mail',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'feuser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.feuser',
			'config' => array(
				'type' => 'select',
				'foreign_class' => '\\TYPO3\\CMS\\Extbase\\Domain\\Model\\FrontendUser',
				'foreign_table' => 'fe_users',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.organisation',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.laststep',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int',
			)
		),
		'finisheduntil' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.finisheduntil',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int',
			)
		),
		'mail_hash' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.mail_hash',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'supporter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.supporter',
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
		'prename' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.prename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'surname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress.surname',
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
?>
