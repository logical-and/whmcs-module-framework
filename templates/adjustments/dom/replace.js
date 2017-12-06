(function() {
	// Definitions
	var path = '{$path}',
		html = '{$html}';

	// Prepare variables
	var target = findNodeByPath(path);

	if (!target) {
		//noinspection UnnecessaryReturnStatementJS
		return;
	}

	target.html(html);
})();