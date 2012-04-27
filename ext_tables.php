<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE')	{

		// TODO make cm items configurable via userTS.
		// @see: t3lib_contextmenu_pagetree_DataProvider
		// @see: get BE user settings from userTS: http://doxygen.frozenkiwi.com/typo3/html/de/d51/class_8clearcachemenu_8php_source.html
	
		// register Ext.Direct provider
	$extPath = t3lib_extMgm::extPath($_EXTKEY);
	t3lib_extMgm::registerExtDirectComponent(
		'TYPO3.SmClearcachecm.ClickmenuAction',
		$extPath . 'Classes/Hooks/ClickmenuAction.php:Tx_SmClearcachecm_Hooks_ClickmenuAction'
	);

		// Include JS in backend 
	$GLOBALS['TYPO3_CONF_VARS']['typo3/backend.php']['additionalBackendItems'][] = t3lib_extMgm::extPath($_EXTKEY, 'Ressources/Private/Php/RegisterJavaScriptForPagetreeAction.php');

		// Add items of the context menu to the default userTS configuration
	$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUserTSconfig'] .= '
		options.contextMenu.table.pages.items {
			900 {
				1010 = DIVIDER

				1020 = ITEM
				1020 {
					name = clearPageCache
					label = LLL:EXT:sm_clearcachecm/Ressources/Private/Language/locallang_cm:clearPageCache
					spriteIcon = actions-system-cache-clear
					callbackAction = clearPageCache
				}
			}
			1000 {
				410 = DIVIDER

				420 = ITEM
				420 {
					name = clearBranchCache
					label = LLL:EXT:sm_clearcachecm/Ressources/Private/Language/locallang_cm:clearBranchCache
					spriteIcon = actions-system-cache-clear-impact-medium
					callbackAction = clearBranchCache
				}
			}
		}
	';
}

?>