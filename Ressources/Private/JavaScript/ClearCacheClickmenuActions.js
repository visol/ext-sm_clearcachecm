Ext.onReady(function() {
	Ext.apply(TYPO3.Components.PageTree.Actions, {
		clearPageCache: function(node, tree) {
			TYPO3.SmClearcachecm.ClickmenuAction.clearPageCache(
				node.attributes.nodeData,
				function(response) {
					if (response) {
						Ext.MessageBox.alert('Clear page cache', response);
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
						Ext.MessageBox.alert('Clear branch cache', response);
					}
				},
				this
			);
		}
	});
});