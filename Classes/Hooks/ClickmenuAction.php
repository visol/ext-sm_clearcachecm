<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Steffen Mueller <typo3@t3node.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   53: class Tx_SmClearcachecm_Hooks_ClickmenuAction
 *   61:     public function clearPageCache($nodeData)
 *   85:     public function clearBranchCache($nodeData)
 *  123:     protected function transformTreeStructureIntoFlatArray($nodeCollection, $level = 0)
 *  148:     protected function performClearCache($nodeUids = array())
 *
 * TOTAL FUNCTIONS: 4
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */


/**
 * Actions for the clickmenu items
 * 1) to clear page cache of a single page
 * 2) to clear page cache of a whole branch
 * 
 * The TYPO3 pagetree implementation uses the noun "node" instead of "page".
 * I decided to follow this terminology.
 *
 * @author		Steffen Mueller <typo3@t3node.com>
 * @package		TYPO3
 * @subpackage	tx_smclearcachecm
 */
class Tx_SmClearcachecm_Hooks_ClickmenuAction {

	/**
	 * Clear page cache action
	 * 
	 * @param	stdClass $nodeData
	 * @return	string Error message for the BE user
	 */
	public function clearPageCache($nodeData) {

		$nodeUids = array();

			/* @var $node t3lib_tree_pagetree_Node */
		$node = t3lib_div::makeInstance('t3lib_tree_pagetree_Node', (array) $nodeData);

			// Get uid of page
		$nodeUids[] = $node->getId();

			// Clear the page cache of the page
		$success = $this->performClearCache($nodeUids);

		if (!$success) {
			return $GLOBALS['LANG']->sL('LLL:EXT:sm_clearcachecm/Ressources/Private/Language/locallang_cm.xml:clearPageCacheError', TRUE);
		}
	}

	/**
	 * Clear branch cache action
	 * 
	 * @param	stdClass $nodeData
	 * @return	string Error message for the BE user
	 */
	public function clearBranchCache($nodeData) {

		$nodeUids = array();
		$childNodeUids = array();

		$nodeLimit = ($GLOBALS['TYPO3_CONF_VARS']['BE']['pageTree']['preloadLimit']) ? $GLOBALS['TYPO3_CONF_VARS']['BE']['pageTree']['preloadLimit'] : 999;

			/* @var $node t3lib_tree_pagetree_Node */
		$node = t3lib_div::makeInstance('t3lib_tree_pagetree_Node', (array) $nodeData);

			// Get uid of actual page
		$nodeUids[] = $node->getId();

			// Get uids of subpages
			/* @var t3lib_tree_pagetree_DataProvider */
		$dataProvider = t3lib_div::makeInstance('t3lib_tree_pagetree_DataProvider', $nodeLimit);
		$nodeCollection = $dataProvider->getNodes($node);
		$childNodeUids = $this->transformTreeStructureIntoFlatArray($nodeCollection);

			// Marge actual and child nodes
		$nodeUids = array_merge($nodeUids, $childNodeUids);

			// Clear the page cache of the nodes
		$success = $this->performClearCache($nodeUids);

		if (!$success) {
			return $GLOBALS['LANG']->sL('LLL:EXT:sm_clearcachecm/Ressources/Private/Language/locallang_cm:clearBranchCacheError', TRUE);
		}
	}

	/**
	 * Recursively transform the node collection from tree structure into a flat array
	 * 
	 * @param	t3lib_tree_NodeCollection $nodeCollection A tree of node
	 * @param	integer $level Recursion counter, used internaly
	 * @return	array Node uids of all child nodes
	 */
	protected function transformTreeStructureIntoFlatArray($nodeCollection, $level = 0) {
		$nodeUids = array();

		if ($level > 99) {
			return array();
		}

		foreach ($nodeCollection as $childNode) {
			$nodeUids[] = $childNode->getId();
			if ($childNode->hasChildNodes()) {
				$nodeUids = array_merge($nodeUids, $this->transformTreeStructureIntoFlatArray($childNode->getChildNodes(), $level + 1));
			} else {
				$nodeUids[] = $childNode->getId();
			}
		}
		return $nodeUids;
	}

	/**
	 * Perform the cache clearing using tcemain
	 * 
	 * @param	array $nodeUids Node uids where the page cache has to be cleared
	 * @throws	string $nodeUids Error message from TCEmain errorLog
	 * @return	boolean TRUE, if clearing of cache was successful
	 */
	protected function performClearCache($nodeUids = array()) {
		if (!empty($nodeUids)) {
				/* @var $tce t3lib_TCEmain */
			$tce = t3lib_div::makeInstance('t3lib_TCEmain');
			$tce->stripslashes_values = 0;
			$tce->start(array(), array());
			foreach ($nodeUids as $nodeUid) {
				$tce->clear_cacheCmd($nodeUid);
			}
		}
			// Check for errors
		if (count($tce->errorLog)) {
			throw new Exception(implode(chr(10), $tce->errorLog));
		}
		return TRUE;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['sm_clearcachecm/Classes/Hooks/ClickmenuAction.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['sm_clearcachecm/Classes/Hooks/ClickmenuAction.php']);
}

?>
