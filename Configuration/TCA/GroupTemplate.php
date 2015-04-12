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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'suggestion' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.suggestion',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'minimum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.minimum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'maximum_age' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.maximum_age',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'max' => 255
			)
		),
		'matrix' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.matrix',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.grouptemplatecategory',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.group_of_group_template',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.isdefault',
			'config' => array(
				'type' => 'check'
			)
		),
		'isoptional' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.isoptional',
			'config' => array(
				'type' => 'check'
			)
		),
		'isfeature' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate.isfeature',
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
?>
