<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
	// Adds JavaScript and LLL for clickmenu to the BE
if (is_object($TYPO3backend)) {
	$pageRenderer = $GLOBALS['TBE_TEMPLATE']->getPageRenderer();
	$pageRenderer->addJsFile('ajax.php?ajaxID=ExtDirect::getAPI&namespace=TYPO3.Smclearcachecm&' . TYPO3_version, NULL, FALSE);

	$jsPath = t3lib_extMgm::extRelPath('sm_clearcachecm') . 'Ressources/Public/JavaScript/';
	$pageRenderer->addJsFile($jsPath . 'ClearCacheClickmenuActions.js');

	$langPath = 'LLL:EXT:sm_clearcachecm/Ressources/Private/Language/locallang_cm.xml:';
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
