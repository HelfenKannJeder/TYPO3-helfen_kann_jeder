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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.organisation',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.addressappendix',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.longitude',
			'config' => array(
				'type' => 'passthrough',
				'size' => 10,
				'eval' => '',
				'max' => 255
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.latitude',
			'config' => array(
				'type' => 'passthrough',
				'size' => 10,
				'eval' => '',
				'max' => 255
			)
		),
		'telephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'reference' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.reference',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address.website',
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
?>
