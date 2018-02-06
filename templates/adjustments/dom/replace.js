(function() {
	// Definitions
	var path = '{$path}',
		html = '{$node}';

	// Prepare variables
	var target = findNodeByPath(path);

	if (!target) {
		//noinspection UnnecessaryReturnStatementJS
		return;
	}

	target.replaceWith(html);
})();