<?php
if(!defined('TYPO3_MODE'))
{
	die ('Access denied.');
}

if('BE' === TYPO3_MODE)
{
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'AlmClearlog',
		'tools',
		'clearlogModule',
		'',
		array(
			\Alm\AlmClearlog\Controller\ClearlogModuleController::class => 'index,clearTable,clearAll',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:alm_clearlog/Resources/Public/Icons/alm_clearlog.png',
			'labels' => 'LLL:EXT:alm_clearlog/Resources/Private/Language/locallang.xlf'
		)
	);
}
