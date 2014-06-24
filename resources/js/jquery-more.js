/* plugin */
jQuery.create = function() {
    if (arguments.length == 0) return [];
    var args = arguments[0] || {}, elem = null, elements = null;
    var siblings = null;

    // In case someone passes in a null object,
    // assume that they want an empty string.
    if (args == null) args = "";
    if (args.constructor == String) {
        if (arguments.length > 1) {
            var attributes = arguments[1];
                if (attributes.constructor == String) {
                            elem = document.createTextNode(args);
                            elements = [];
                            elements.push(elem);
                            siblings =
        jQuery.create.apply(null, Array.prototype.slice.call(arguments, 1));
                            elements = elements.concat(siblings);
                            return elements;

                    } else {
                            elem = document.createElement(args);

                            // Set element attributes.
                            var attributes = arguments[1];
                            for (var attr in attributes)
                                jQuery(elem).attr(attr, attributes[attr]);

                            // Add children of this element.
                            var children = arguments[2];
							if (children) {
								children = jQuery.create.apply(null, children);
	                            jQuery(elem).append(children);
							}

                            // If there are more siblings, render those too.
                            if (arguments.length > 3) {
                                    siblings =
        jQuery.create.apply(null, Array.prototype.slice.call(arguments, 3));
                                    return [elem].concat(siblings);
                            }
                            return elem;
                    }
            } else return document.createTextNode(args);
      } else {
              elements = [];
              elements.push(args);
              siblings =
        jQuery.create.apply(null, (Array.prototype.slice.call(arguments, 1)));
              elements = elements.concat(siblings);
              return elements;
      }
};

jQuery.fn.addEvent = jQuery.fn.bind; //updated

function proxy( fn, context ) {
	if ( typeof context === "string" ) {
		var tmp = fn[ context ];
		context = fn;
		fn = tmp;
	}

	// Quick check to determine if target is callable, in the spec
	// this throws a TypeError, but we will just return undefined.
	if ( !jQuery.isFunction( fn ) ) {
		return undefined;
	}

	// Simulated bind
	var args = objToAry(arguments, 2);
	var proxy = function() {
		var args2 = objToAry(arguments);
		return fn.apply( context, args2.concat(args) );
	};

	// Set the guid of unique handler to the same of original handler, so it can be removed
	proxy.guid = fn.guid = fn.guid || proxy.guid || jQuery.guid++;

	return proxy;
}
function objToAry(obj, i) {
	if (isNaN(i)) i = 0;
	var ary = [], arg;
	while (arg = obj[i]) {
		ary.push(arg);
		i++;
	}
	return ary
}

(function($) {
	/*

	You can now create a spinner using any of the variants below:

	$("#el").spin(); // Produces default Spinner using the text color of #el.
	$("#el").spin("small"); // Produces a 'small' Spinner using the text color of #el.
	$("#el").spin("large", "white"); // Produces a 'large' Spinner in white (or any valid CSS color).
	$("#el").spin({ ... }); // Produces a Spinner using your custom settings.

	$("#el").spin(false); // Kills the spinner.

	*/

	$.fn.spin = function(opts, color) {
		var presets = {
			"tiny": { lines: 8, length: 2, width: 2, radius: 3 },
			"small": { lines: 8, length: 4, width: 3, radius: 5 },
			"large": { lines: 10, length: 8, width: 4, radius: 8 }
		};
		if (Spinner) {
			return this.each(function() {
				var $this = $(this),
					data = $this.data();

				if (data.spinner) {
					data.spinner.stop();
					delete data.spinner;
				}
				if (opts !== false) {
					if (typeof opts === "string") {
						if (opts in presets) {
							opts = presets[opts];
						} else {
							opts = {};
						}
						if (color) {
							opts.color = color;
						}
					}
					if(this.nodeName.toLowerCase() == 'input') {
						var pos = $this.position();
						data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin();
						$(data.spinner.el).css({
							position: 'absolute',
							top: pos.top+4+'px',
							left: pos.left+$this.width()-4+'px'
						}).insertAfter($this);
					} else {
						data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
					}
				}
			});
		} else {
			throw "Spinner class not available.";
		}
	};

})(jQuery);


jQuery.fn.cssNumber = function(prop){
    var v = parseInt(this.css(prop),10);
    return isNaN(v) ? 0 : v;
};