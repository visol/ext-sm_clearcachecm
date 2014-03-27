<?php
namespace T3node\SmClearcachecm\Hooks;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Actions for the clickmenu items
 * 1) to clear page cache of a single page
 * 2) to clear page cache of a whole branch
 *
 * The TYPO3 pagetree implementation uses the noun "node" instead of "page".
 * I decided to follow this terminology.
 *
 */
class ClickmenuAction {

	/**
	 * Clear page cache action
	 *
	 * @param array $nodeData
	 * @return string Error message for the BE user
	 */
	public function clearPageCache($nodeData) {
			/* @var $node \TYPO3\CMS\Backend\Tree\Pagetree\PagetreeNode */
		$node = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Tree\\Pagetree\\PagetreeNode', (array) $nodeData);

			// Get uid of page
		$nodeUids = array(
			$node->getId()
		);

		// Clear the cache of the page
		$result = $this->performClearCache($nodeUids);

		return $result;
	}

	/**
	 * Clear branch cache action
	 *
	 * @param array $nodeData
	 * @return string Error message for the BE user
	 */
	public function clearBranchCache($nodeData) {
		$nodeLimit = ($GLOBALS['TYPO3_CONF_VARS']['BE']['pageTree']['preloadLimit']) ? $GLOBALS['TYPO3_CONF_VARS']['BE']['pageTree']['preloadLimit'] : 999;

			/* @var \TYPO3\CMS\Backend\Tree\Pagetree\PagetreeNode $node */
		$node = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Tree\\Pagetree\\PagetreeNode', (array) $nodeData);

			// Get uid of actual page
		$nodeUids = array(
			$node->getId()
		);

			// Get uids of subpages
			/* @var \TYPO3\CMS\Backend\Tree\Pagetree\DataProvider $dataProvider */
		$dataProvider = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Tree\\Pagetree\\DataProvider', $nodeLimit);
		$nodeCollection = $dataProvider->getNodes($node);
		$childNodeUids = $this->transformTreeStructureIntoFlatArray($nodeCollection);

			// Marge actual and child nodes
		$nodeUids = array_merge($nodeUids, $childNodeUids);

			// Clear the page cache of the nodes
		$result = $this->performClearCache($nodeUids);

		return $result;
	}

	/**
	 * Recursively transform the node collection from tree structure into a flat array
	 *
	 * @param \TYPO3\CMS\Backend\Tree\TreeNodeCollection $nodeCollection A tree of node
	 * @param integer $level Recursion counter, used internaly
	 * @return array Node uids of all child nodes
	 */
	protected function transformTreeStructureIntoFlatArray($nodeCollection, $level = 0) {
		if ($level > 99) {
			return array();
		}

		$nodeUids = array();
		/** @var \TYPO3\CMS\Backend\Tree\TreeNode $childNode */
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
	 * @param array $nodeUids Node uids where the page cache has to be cleared
	 * @return boolean TRUE, if clearing of cache was successful
	 * @throws string $nodeUids Error message from TCEmain errorLog
	 */
	protected function performClearCache($nodeUids = array()) {
		if (empty($nodeUids)) {
			return TRUE;
		}

		/* @var $dataHandler \TYPO3\CMS\Core\DataHandling\DataHandler */
		$dataHandler = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
		$dataHandler->stripslashes_values = 0;
		$dataHandler->start(array(), array());
		foreach ($nodeUids as $nodeUid) {
			$dataHandler->clear_cacheCmd($nodeUid);
		}

			// Check for errors
		if (count($dataHandler->errorLog)) {
			throw new \Exception(implode(chr(10), $dataHandler->errorLog));
		}

		return TRUE;
	}
}
