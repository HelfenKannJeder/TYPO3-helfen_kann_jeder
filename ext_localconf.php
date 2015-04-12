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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' .$_EXTKEY,
	'List',
	array(
		'Register' => 'showstep10,sendstep10,showstep20,sendstep31,showstep32,sendstep32,showstep33,sendstep33,showstep40,sendstep40,showstep50,sendstep50,showstep60,sendstep60,showstep70,sendstep70,showstep71,sendstep71,showstep80,sendstep80,showstep81,showstep90,doNotRemindMe',
		'Support' => 'index,diff,live2test,test2live,view,deny,back',
		'Organisation' => 'index,show,general,generalSend,group,groupSend,workinghour,workinghourSend,picture,pictureSend,matrix,changeStatus',
		'UserSettings' => 'edit,save',
		'HelfOMat' => 'quiz,groupResult,jsonGroupResult',
		'SupportMaster' => 'reenableScreeningOrganisation',
		'Location' => 'index',
		'Map' => 'index,kml',
		'Overview' => 'index,detail',
		'Matrix' => 'view,column',
		'Backer' => 'index',
	),
	array(
		'Register' => 'showstep10,sendstep10,showstep20,sendstep31,showstep32,sendstep32,showstep33,sendstep33,showstep40,sendstep40,showstep50,sendstep50,showstep60,sendstep60,showstep70,sendstep70,showstep71,sendstep71,showstep80,sendstep80,showstep81,showstep90,doNotRemindMe',
		'Support' => 'index,diff,live2test,test2live,view,deny,back',
		'Organisation' => 'index,show,general,generalSend,group,groupSend,workinghour,workinghourSend,picture,pictureSend,matrix,statusChange',
		'UserSettings' => 'edit,save',
		'HelfOMat' => 'groupResult,jsonGroupResult',
		'SupportMaster' => 'reenableScreeningOrganisation',
		'Overview' => 'index',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' . $_EXTKEY,
	'Right',
	array(
		'Information' => 'organisation,loggedIn,map',
		'Location' => 'index',
		'Picture' => 'index',
	)
);

/**
 * Hooking for PluginInfo
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['helfenkannjeder_list']['helfenkannjeder'] =
	'EXT:helfen_kann_jeder/Classes/Utility/PluginInfo.php:Querformatik\\HelfenKannJeder\\Utility\\PluginInfo->getInfo';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Querformatik\\HelfenKannJeder\\Command\\RemindCommandController';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Querformatik\\HelfenKannJeder\\Command\\OrganisationCommandController';
?>
