<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
	// Adds JavaScript and LLL for clickmenu to the BE
if (is_object($TYPO3backend)) {

	/** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
	$pageRenderer = $GLOBALS['TBE_TEMPLATE']->getPageRenderer();

	$jsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('sm_clearcachecm') . 'Resources/Public/JavaScript/';
	$pageRenderer->addJsFile($jsPath . 'ClearCacheClickmenuActions.js');

	$langPath = 'LLL:EXT:sm_clearcachecm/Resources/Private/Language/locallang_cm.xlf:';
	$pageRenderer->addInlineLanguageLabel(
		'sm_clearcachecm_clearPageCacheSuccess',
		$GLOBALS['LANG']->sL($langPath . 'clearPageCacheSuccess', TRUE)
	);
	$pageRenderer->addInlineLanguageLabel(
		'sm_clearcachecm_clearPageCacheError',
		$GLOBALS['LANG']->sL($langPath . 'clearPageCacheError', TRUE)
	);
	$pageRenderer->addInlineLanguageLabel(
		'sm_clearcachecm_clearBranchCacheSuccess',
		$GLOBALS['LANG']->sL($langPath . 'clearBranchCacheSuccess', TRUE)
	);
	$pageRenderer->addInlineLanguageLabel(
		'sm_clearcachecm_clearBranchCacheError',
		$GLOBALS['LANG']->sL($langPath . 'clearBranchCacheError', TRUE)
	);
}
