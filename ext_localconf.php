<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' .$_EXTKEY,
	'List',
	array(
		'Register' => 'showstep10,sendstep10,showstep20,sendstep31,showstep32,sendstep32,showstep33,sendstep33,showstep40,sendstep40,showstep50,sendstep50,showstep60,sendstep60,showstep70,sendstep70,showstep71,sendstep71,showstep80,sendstep80,showstep81,showstep90,upload,doNotRemindMe',
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
		'Register' => 'showstep10,sendstep10,showstep20,sendstep31,showstep32,sendstep32,showstep33,sendstep33,showstep40,sendstep40,showstep50,sendstep50,showstep60,sendstep60,showstep70,sendstep70,showstep71,sendstep71,showstep80,sendstep80,showstep81,showstep90,upload,doNotRemindMe',
		'Support' => 'index,diff,live2test,test2live,view,deny,back',
		'Organisation' => 'index,show,general,generalSend,group,groupSend,workinghour,workinghourSend,picture,pictureSend,matrix,statusChange',
		'UserSettings' => 'edit,save',
		'HelfOMat' => 'groupResult,jsonGroupResult',
		'SupportMaster' => 'reenableScreeningOrganisation',
		'Overview' => 'index',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' .$_EXTKEY,
	'Location',
	array(
		'Location' => 'index',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' .$_EXTKEY,
	'PictureList',
	array(
		'Picture' => 'index',
	)
);

/** @deprecated */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' .$_EXTKEY,
	'MapList',
	array(
		'Map' => 'index,kml',
	)
);

/** @deprecated */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' .$_EXTKEY,
	'OverviewList',
	array(
		'Overview' => 'index,detail',
		'Matrix' => 'view,column',
	),
	array(
		'Overview' => 'index',
	)
);

/** @deprecated */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Querformatik.' .$_EXTKEY,
	'BackerList',
	array(
		'Backer' => 'index',
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
