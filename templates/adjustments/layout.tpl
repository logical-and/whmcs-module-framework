<script type="text/javascript">
	(function () {
		var handler = function () {
			var $ = jQuery;
			var findNodeByPath = function (path) {
				var paths = path.replace(/</g, ':parent()').replace(/(:parent\(\))/g, '|$1|').split('|');

				var target;
				for (var i = 0; i < paths.length; i++) {
					// Skip empty elements
					if (!$.trim(paths[i])) {
						continue;
		      }

					if (!target) {
			      target = $(paths[i]);
		      }
		      else if (':parent()' == paths[i]) {
			      target = target.parent();
		      }
		      else {
		        target = target.find(paths[i]);
					}
				}

				if (!target[0]) {
					console.warn('"' + path + '" is not found to replace');
				}

		    return target;
			};
			{$code}
		};

		if (!window.jQuery) {
			var script = document.createElement('script');
			script.onload = handler;
			script.src = '{$jQueryScript}';

			document.head.appendChild(script);
		}
		else {
			handler();
		}
	})();
</script>