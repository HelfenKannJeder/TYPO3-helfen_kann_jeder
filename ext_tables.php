<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'List',
	'HelfenKannJeder'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'GeneratorList',
	'Generator'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'MapList',
	'Map'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'OverviewList',
	'Overview'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'CitysignList',
	'Citysign'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'PictureList',
	'Picture'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'EmployeeList',
	'Employee'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'EmployeeDetail',
	'Employee Details'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'TestList',
	'Test'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'BackerList',
	'Backer'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Querformatik.' .$_EXTKEY,
	'Location',
	'Location'
);

if (TYPO3_MODE == 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Querformatik.' .$_EXTKEY,
		'web',    // Make module a submodule of 'web'
		'helfenkannjeder',    // Submodule key
		'after:list', // Position
		array(
			// An array holding the controller-action-combinations that are accessible
			'Matrix'	=> 'backend,import',
			'SupportMaster'	=> 'index,overview,organisation,mailtest,diff,registerLink',
			'HelfOMat'	=> 'master',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:'.$_EXTKEY.'/Resources/Public/Icons/icon_helfen_kann_jeder_backend_module.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
			'navigationComponentId' => 'typo3-pagetree',
		)
	);
}

$TCA['tx_helfenkannjeder_domain_model_organisationtype'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationtype',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/OrganisationType.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_organisation_type.gif'
							// source: http://de.fotolia.com/id/12600401
	)
);

$TCA['tx_helfenkannjeder_domain_model_organisation'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisation',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'versioningWS'			=> TRUE,
		'origUid'			=> 't3_origuid',
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Organisation.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_organisation.gif'
							// source: http://de.fotolia.com/id/12600401
	)
);

$TCA['tx_helfenkannjeder_domain_model_organisationdraft'] = $TCA['tx_helfenkannjeder_domain_model_organisation'];
$TCA['tx_helfenkannjeder_domain_model_organisationdraft']['ctrl']['title'] = 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_organisationdraft';

$TCA['tx_helfenkannjeder_domain_model_group'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_group',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Group.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_group.gif',
		'sortby'			=> 'sort'
	)
);

$TCA['tx_helfenkannjeder_domain_model_groupdraft'] = $TCA['tx_helfenkannjeder_domain_model_group'];
$TCA['tx_helfenkannjeder_domain_model_groupdraft']['ctrl']['title'] = 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_groupdraft';

$TCA['tx_helfenkannjeder_domain_model_grouptemplatecategory'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplatecategory',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/GroupTemplateCategory.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_grouptemplatecategory.gif',
		'sortby'			=> 'sort',
	)
);

$TCA['tx_helfenkannjeder_domain_model_groupofgrouptemplate'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_groupedgrouptemplate',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/GroupOfGroupTemplate.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_groupofgrouptemplate.gif'
	),
);


$TCA['tx_helfenkannjeder_domain_model_grouptemplate'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_grouptemplate',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/GroupTemplate.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_grouptemplate.gif',
		'sortby'			=> 'sort',
	)
);

$TCA['tx_helfenkannjeder_domain_model_activityfield'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_activityfield',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/ActivityField.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_activityfield.gif'
	)
);

$TCA['tx_helfenkannjeder_domain_model_activity'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_activity',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Activity.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_activity.gif'
	)
);

$TCA['tx_helfenkannjeder_domain_model_employee'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_employee',
		'label'				=> 'surname',
		'label_alt'			=> 'prename',
		'label_alt_force'		=> true,
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Employee.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_employee.gif'
	)
);
$TCA['tx_helfenkannjeder_domain_model_employeedraft'] = $TCA['tx_helfenkannjeder_domain_model_employee'];
$TCA['tx_helfenkannjeder_domain_model_employeedraft']['ctrl']['title'] = 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_employeedraft';

$TCA['tx_helfenkannjeder_domain_model_matrixfield'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_matrixfield',
		'label'				=> 'matrix',
		'label_alt'			=> 'activity, activityfield, grade',
		'label_alt_force'		=> true,
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/MatrixField.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_matrixfield.gif'
	)
);

$TCA['tx_helfenkannjeder_domain_model_matrix'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_matrix',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Matrix.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_matrix.gif'
		
	)
);

$TCA['tx_helfenkannjeder_domain_model_workinghour'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghour',
		'label'				=> 'day',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Workinghour.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_workinghour.gif'
		
	)
);
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft'] = $TCA['tx_helfenkannjeder_domain_model_workinghour'];
$TCA['tx_helfenkannjeder_domain_model_workinghourdraft']['ctrl']['title'] = 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_workinghourdraft';

$TCA['tx_helfenkannjeder_domain_model_address'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_address',
		'label'				=> 'city',
		'label_alt'			=> 'street',
		'label_alt_force'		=> true,
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Address.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_address.gif'
		
	)
);

$TCA['tx_helfenkannjeder_domain_model_addressdraft'] = $TCA['tx_helfenkannjeder_domain_model_address'];
$TCA['tx_helfenkannjeder_domain_model_addressdraft']['ctrl']['title'] = 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_addressdraft';

$TCA['tx_helfenkannjeder_domain_model_backer'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_backer',
		'label'				=> 'surname',
		'label_alt'			=> 'prename, company',
		'label_alt_force'		=> true,
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Backer.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_backer.gif',
		'sortby'			=> 'sort'
		
	)
);

$TCA['tx_helfenkannjeder_domain_model_registerorganisationprogress'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_registerorganisationprogress',
		'label'				=> 'organisationtype',
		'label_alt'			=> 'city, department',
		'label_alt_force'		=> true,
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/RegisterOrganisationProgress.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_registerorganisationprogress.gif'
		
	)
);

$TCA['tx_helfenkannjeder_domain_model_log'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_log',
		'label'				=> 'feuser',
		'label_alt'			=> 'message',
		'label_alt_force'		=> true,
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/Log.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_log.gif'
		
	)
);

$TCA['tx_helfenkannjeder_domain_model_helfomat'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomat',
		'label'				=> 'name',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/HelfOMat.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_helfomat.gif'
	),
);

$TCA['tx_helfenkannjeder_domain_model_helfomatquestion'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:tx_helfenkannjeder_domain_model_helfomatquestion',
		'label'				=> 'question',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'languageField'			=> 'sys_language_uid',
		'transOrigPointerField'		=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy'			=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields'		=> 'sys_language_uid',
		'useColumnsForDefaultValues'	=> 'sys_language_uid',
		'delete'			=> 'deleted',
		'sortby'			=> 'sort',
		'enablecolumns'			=> array(
			'disabled'		=> 'hidden'
		),
		'dynamicConfigFile'		=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Configuration/TCA/HelfOMatQuestion.php',
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'Resources/Public/Icons/icon_helfen_kann_jeder_domain_model_helfomatquestion.gif'
	),
);

\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('fe_users');
if (is_array($TCA['fe_users']['columns']['tx_extbase_type'])) {
        $TCA['fe_users']['types']['Tx_HelfenKannJeder_Domain_Model_Supporter'] = $TCA['fe_users']['types']['0'];
        array_push($TCA['fe_users']['columns']['tx_extbase_type']['config']['items'], array('LLL:EXT:helfen_kann_jeder/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_HelfenKannJeder_Domain_Model_Supporter', 'Querformatik\\HelfenKannJeder\\Domain\\Model\\Supporter'));
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'HelfenKannJeder Setup');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/DefaultStyles', 'HelfenKannJeder CSS Styles (optional)');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/HelfOMat', 'HelfenKannJeder HelfOMat');

$pluginSignature = strtolower($extensionName) . '_list';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform,recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_organisation.xml');
?>
