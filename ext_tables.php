<?php
if(!defined('TYPO3_MODE'))
{
	die ('Access denied.');
}

if('BE' === TYPO3_MODE)
{
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Alm.' . $_EXTKEY,
		'tools',
		'clearlogModule',
		'',
		array(
			'ClearlogModule' => 'index,clearTable,clearAll',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/alm_clearlog.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf'
		)
	);
}
