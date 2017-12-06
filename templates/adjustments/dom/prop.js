(function() {
	// Definitions
	var path = '{$path}',
		prop = '{$prop}',
		value = '{$value}';

	// Prepare variables
	var target = findNodeByPath(path);

	if (!target) {
		//noinspection UnnecessaryReturnStatementJS
		return;
	}

	// Event listener
	if (prop.match(/^on/)) {
		target.attr(prop, value);
	}
	else {
		target.prop(prop, value);
	}
})();