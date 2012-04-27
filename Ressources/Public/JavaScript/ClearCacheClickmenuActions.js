Ext.onReady(function() {
	Ext.apply(TYPO3.Components.PageTree.Actions, {
		clearPageCache: function(node, tree) {
			TYPO3.SmClearcachecm.ClickmenuAction.clearPageCache(
				node.attributes.nodeData,
				function(response) {
					if (response) {
						TYPO3.Flashmessage.display(TYPO3.Severity.error, '', response);
					} else {
						TYPO3.Flashmessage.display(TYPO3.Severity.ok, '', TYPO3.lang.sm_clearcachecm_clearPageCacheSuccess);
					}
				},
				this
			);
		}
	});
	Ext.apply(TYPO3.Components.PageTree.Actions, {
		clearBranchCache: function(node, tree) {
			TYPO3.SmClearcachecm.ClickmenuAction.clearBranchCache(
				node.attributes.nodeData,
				function(response) {
					if (response) {
						TYPO3.Flashmessage.display(TYPO3.Severity.error, '', response);
					} else {
						TYPO3.Flashmessage.display(TYPO3.Severity.ok, '', TYPO3.lang.sm_clearcachecm_clearBranchCacheSuccess);
					}
				},
				this
			);
		}
	});
});
