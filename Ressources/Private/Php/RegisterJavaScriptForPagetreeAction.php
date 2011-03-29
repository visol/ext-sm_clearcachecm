<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
	// Adds JavaScript for clickmenu to the BE
if (is_object($TYPO3backend)) {
	$pageRenderer = $GLOBALS['TBE_TEMPLATE']->getPageRenderer();
	$pageRenderer->addJsFile('ajax.php?ajaxID=ExtDirect::getAPI&namespace=TYPO3.Smclearcachecm&' . TYPO3_version, NULL, FALSE);

	$path = t3lib_extMgm::extRelPath('sm_clearcachecm') . 'Ressources/Private/JavaScript/';
	$pageRenderer->addJsFile($path . 'ClearCacheClickmenuActions.js');
}

?>