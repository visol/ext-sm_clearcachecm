<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
	// Adds JavaScript and LLL for clickmenu to the BE
if (is_object($TYPO3backend)) {
	$pageRenderer = $GLOBALS['TBE_TEMPLATE']->getPageRenderer();

	$jsPath = t3lib_extMgm::extRelPath('sm_clearcachecm') . 'Resources/Public/JavaScript/';
	$pageRenderer->addJsFile($jsPath . 'ClearCacheClickmenuActions.js');

	$langPath = 'LLL:EXT:sm_clearcachecm/Resources/Private/Language/locallang_cm.xml:';
	$pageRenderer->addInlineLanguageLabel(
		'sm_clearcachecm_clearPageCacheSuccess',
		$GLOBALS['LANG']->sL($langPath . 'clearPageCacheSuccess', TRUE)
	);
	$pageRenderer->addInlineLanguageLabel(
		'sm_clearcachecm_clearBranchCacheSuccess',
		$GLOBALS['LANG']->sL($langPath . 'clearBranchCacheSuccess', TRUE)
	);
}

?>