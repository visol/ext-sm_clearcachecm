Ext.onReady(function() {
	Ext.apply(TYPO3.Components.PageTree.Actions, {
		clearPageCache: function(node, tree) {
			TYPO3.SmClearcachecm.ClickmenuAction.clearPageCache(
				node.attributes.nodeData,
				function(response) {
					if (response) {
						TYPO3.Flashmessage.display(TYPO3.Severity.information, TYPO3.lang.sm_clearcachecm_clearPageCache, response, 5);
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
						TYPO3.Flashmessage.display(TYPO3.Severity.information, TYPO3.lang.sm_clearcachecm_clearBranchCache, response, 5);
					}
				},
				this
			);
		}
	});
});
