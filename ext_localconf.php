<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'List',
	array(
		'Register' => 'showstep10,sendstep10,showstep20,sendstep31,showstep32,sendstep32,showstep33,sendstep33,showstep40,sendstep40,showstep50,sendstep50,showstep60,sendstep60,showstep70,sendstep70,showstep71,sendstep71,showstep80,sendstep80,showstep81,showstep90,upload,doNotRemindMe',
		'Support' => 'index,diff,live2test,test2live,view,deny,back',
		'Organisation' => 'index,show,general,generalSend,group,groupSend,workinghour,workinghourSend,picture,pictureSend,matrix,changeStatus',
		'UserSettings' => 'edit,save',
		'Cron' => 'execute',
		'HelfOMat' => 'quiz,result,groupResult,detail,jsonGroupResult',
		'SupportMaster' => 'reenableScreeningOrganisation',
		'Location' => 'index'
	),
	array(
		'Register' => 'showstep10,sendstep10,showstep20,sendstep31,showstep32,sendstep32,showstep33,sendstep33,showstep40,sendstep40,showstep50,sendstep50,showstep60,sendstep60,showstep70,sendstep70,showstep71,sendstep71,showstep80,sendstep80,showstep81,showstep90,upload,doNotRemindMe',
		'Support' => 'index,diff,live2test,test2live,view,deny,back',
		'Organisation' => 'index,show,general,generalSend,group,groupSend,workinghour,workinghourSend,picture,pictureSend,matrix,statusChange',
		'UserSettings' => 'edit,save',
		'Cron' => 'execute',
		'HelfOMat' => 'result,groupResult,detail',
		'SupportMaster' => 'reenableScreeningOrganisation',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'GeneratorList',
	array(
		'Generator' => 'index,ajaxorganisation,autocomplete',
	),
	array(
		'Generator' => 'ajaxorganisation,autocomplete',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'MapList',
	array(
		'Map' => 'index,kml',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'OverviewList',
	array(
		'Overview' => 'index,detail',
		'Matrix' => 'view,column',
	),
	array(
		'Overview' => 'index',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'CitysignList',
	array(
		'Citysign' => 'index,edit,ajaxrememberaddress',
	),
	array(
		'Citysign' => 'ajaxrememberaddress'
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'PictureList',
	array(
		'Picture' => 'index',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'EmployeeList',
	array(
		'Employee' => 'index,detail',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'EmployeeDetail',
	array(
		'Employee' => 'detail',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'BackerList',
	array(
		'Backer' => 'index',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Location',
	array(
		'Location' => 'index',
	)
);

/**
 * Hooking for PluginInfo
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['helfenkannjeder_list']['helfenkannjeder'] =
	'EXT:helfen_kann_jeder/Classes/Utility/PluginInfo.php:Tx_HelfenKannJeder_Utility_PluginInfo->getInfo';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Tx_HelfenKannJeder_Command_RemindCommandController';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Tx_HelfenKannJeder_Command_OrganisationCommandController';
?>
