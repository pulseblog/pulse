/**
 * The global App object will handle the instantiation and initialization of
 * JavaScript objects that will manipulate the DOM.
 *
 * Basically it will look for elements with `data-module` attribute and
 * initialize an object using the given constructor.
 *
 * Example:
 *     <span class='something' data-module='ModuleName'>Hi!</span>
 *     // Will run `ModuleName($el)` constructor where $el is the
 *     // span element itself.
 *
 * @type {Object}
 */
function App() {}

/**
 * Initializes the application
 * @return {boolean} Successful
 */
App.prototype.init = function() {
	this.log('initializing application...');
	return this.run();
};

/**
 * Retrieve all elements that have the `data-module` attribute
 * @return {DOM Elements} A bunch of dom elements
 */
App.prototype.getDynamicDom = function() {
	return $('[data-module]');
};

/**
 * Run the application. Iterates trought every dynamic dom element found and
 * initializes the modules specified in the data-module attribute of each
 * @return {boolean} Success
 */
App.prototype.run = function() {
	var _this = this;
	var $elements = this.getDynamicDom();

	$elements.each(function(i, el){
		var $el = $(el);
		var moduleNames = $el.attr('data-module');

		// Split/cast into an array and reverse it
		moduleNames = moduleNames.split(' ').reverse();

		// The moduleNames may or may not be an array
		_this.initModule($el, moduleNames);
	});

	return true;
};

/**
 * Run the constructor for each of the moduleNames passing the $el as the
 * constructor parameter
 * @param  {DOM Element} $el
 * @param  {Array} moduleNames Array of module names
 * @return {void}
 */
App.prototype.initModule = function ($el, moduleNames) {
	var i = moduleNames.length;

	while(i--) {
		if (typeof window[moduleNames[i]] === 'function') {
			new window[moduleNames[i]]($el);
		} else {
			throw "constructor or function '"+ moduleNames[i] + "' is not defined.";
		}
	}
};

/**
 * Encapsulates the console.log in order to have a better compatibility and
 * a easy way to turn debug off
 * @param  {mixed} content
 * @return {void}
 */
App.prototype.log = function(content) {
	if (typeof window.console !== 'undefined') {
		window.console.log(content);
	}
};
