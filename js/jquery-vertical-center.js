// By: Dan Colonna @danomak
// Authored: May. 5th 2013

// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function ( $, window, document, undefined ) {

    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = "verticalCenter",
        defaults = {
            checkHeightChange: false
        };

    // The actual plugin constructor
    function Plugin(element, options) {
        this.element = element;

        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.options = $.extend( {}, defaults, options );

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function() {

         var	$this = $(this.element),
         _this = this,
         elementHeight = Math.round($this.height()),
                parentHeight = $this.parent().height(),
                centeringOffset;

         _this.centerElement($this, parentHeight, elementHeight);

            if (_this.options.checkHeightChange == true) {
     setInterval(function() {
     _this.checkElementHeight($this, parentHeight, elementHeight)
     }, 500);
            }

            // Place initialization logic here
            // You already have access to the DOM element and
            // the options via the instance, e.g. this.element
            // and this.options
            // you can add more functions like the one below and
            // call them like so: this.yourOtherFunction(this.element, this.options).
        },

        centerElement: function($el, pHeight, eHeight) {
centeringOffset = Math.round(pHeight - eHeight) / 2;
$el.css('margin-top', centeringOffset);
},

checkElementHeight: function($el, pHeight, eHeight) {
// see if the element's height has changed since it was last set
if (eHeight != $el.height()) {
// if it was, update the elementHeight variable to match the new height
eHeight = $el.height();

//console.log('height changed to!' + eHeight);

// re-center the elementoff of the new height
this.centerElement($el, pHeight, eHeight);
}
}
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );