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

$TCA['tx_helfenkannjeder_domain_model_groupofgrouptemplate'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_groupofgrouptemplate']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, group_templates',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_groupofgrouptemplate',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_groupofgrouptemplate.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_groupofgrouptemplate.sys_language_uid IN (-1, 0)',
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
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_groupofgrouptemplate.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'group_templates' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_groupofgrouptemplate.group_templates',
			'config' => array(
				'type' => 'passthrough',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, name, group_templates')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>
