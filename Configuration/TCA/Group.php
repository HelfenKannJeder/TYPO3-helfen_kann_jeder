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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'workinghours' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.workinghours',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'website' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255
			)
		),
		'minimum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.minimum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'maximum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.maximum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'matrix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.matrix',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			)
		),
		'zipcode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.longitude',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'double2',
				'max' => 255
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.latitude',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'double2',
				'max' => 255
			)
		),
		'organisation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.organisation',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.grouptemplate',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.contactpersons',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group.reference',
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
?>
