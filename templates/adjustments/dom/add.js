(function() {
	// Definitions
	var path = '{$path}',
		position = '{$position}',
		node = '{$node}';

	// Prepare variables
	node = $(node);
	var target = findNodeByPath(path);

	if (!target) {
		//noinspection UnnecessaryReturnStatementJS
		return;
	}

	target['before' == position ? 'before' : 'after'](node);
})();