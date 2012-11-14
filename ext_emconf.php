<?php

########################################################################
# Extension Manager/Repository config file for ext "sm_clearcachecm".
#
# Auto generated 14-11-2012 01:12
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Clear cache clickmenu items',
	'description' => 'Adds items to the pagetree clickmenu to clear the cache of pages. Either clears cache of a single page or a whole branch. Two clicks are enough! Needs TYPO3 4.5 or later.',
	'category' => 'be',
	'shy' => 0,
	'version' => '2.2.1',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'cm1',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Steffen Mueller',
	'author_email' => 'typo3@t3node.com',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:9:{s:9:"ChangeLog";s:4:"1924";s:12:"ext_icon.gif";s:4:"7bff";s:14:"ext_tables.php";s:4:"cea3";s:10:"README.txt";s:4:"ee2d";s:33:"Classes/Hooks/ClickmenuAction.php";s:4:"788a";s:44:"Ressources/Private/Language/locallang_cm.xml";s:4:"fa07";s:62:"Ressources/Private/Php/RegisterJavaScriptForPagetreeAction.php";s:4:"10ca";s:58:"Ressources/Public/JavaScript/ClearCacheClickmenuActions.js";s:4:"a2a6";s:14:"doc/manual.sxw";s:4:"cbfa";}',
	'suggests' => array(
	),
);

?>