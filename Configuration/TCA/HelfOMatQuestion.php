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

$TCA['tx_helfenkannjeder_domain_model_helfomatquestion'] = array(
	'ctrl' => $TCA['tx_helfenkannjeder_domain_model_helfomatquestion']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'helfomat, question, description, group_positive, group_negative, group_positivenot, group_negativenot, positive, negative, positivenot, negativenot, sort',
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
				'foreign_table' => 'tx_helfenkannjeder_domain_model_helfomatquestion',
				'foreign_table_where' => 'AND tx_helfenkannjeder_domain_model_helfomatquestion.uid=###REC_FIELD_l18n_parent### AND tx_helfenkannjeder_domain_model_helfomatquestion.sys_language_uid IN (-1, 0)',
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
		'helfomat' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.helfomat',
			'config' => array(
				'type' => 'select',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_helfomat.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_helfomat',
			)
		),
		'question' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.question',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'max' => 255
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'eval' => 'trim',
				'rows' => 4
			)
		),
		'positive' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.positive',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_activity.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_positive_activity_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'negative' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.negative',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_activity.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_negative_activity_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'positivenot' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.positivenot',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_activity.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_positive_not_activity_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'negativenot' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.negativenot',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_activity.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_activity',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_negative_not_activity_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'group_positive' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.group_positive',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_groupofgrouptemplate.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_groupofgrouptemplate',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_positive_gogt_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'group_negative' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.group_negative',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_groupofgrouptemplate.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_groupofgrouptemplate',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_negative_gogt_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'group_positivenot' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.group_positivenot',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_groupofgrouptemplate.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_groupofgrouptemplate',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_positive_not_gogt_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'group_negativenot' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion.group_negativenot',
			'config' => array(
				'type' => 'select',
				'size' => 30,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'multiple' => 0,
				'foreign_table_where' => 'ORDER BY tx_helfenkannjeder_domain_model_groupofgrouptemplate.name',
				'foreign_table' => 'tx_helfenkannjeder_domain_model_groupofgrouptemplate',
				'MM' => 'tx_helfenkannjeder_helfomatquestion_negative_not_gogt_mm',
				'wizards' => array(
				),
				'suppress_icons' => 1,
                                'selectedListStyle' => 'height:300px;width:400px',
                                'itemListStyle' => 'height:300px;width:400px',
			)
		),
		'sort' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, helfomat, question, description, group_positive, group_negative, group_positivenot, group_negativenot, positive, negative, positivenot, negativenot, sort')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>
