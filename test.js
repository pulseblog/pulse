/**
 * The Test constructor will make sure to require all the scripts and the
 * respective test files.
 *
 * PS: This file is intented to be loaded by mocha using Node.js
 *
 * @type {function}
 */
Test = function Test() {
    this.fs          = require("fs");
    this.scriptsPath = './app/assets/js/';
    this.testsPath   = './app/tests/js/';
}

/**
 * Recursively require files within the given path
 * @param  {string} path
 * @return {void}
 */
Test.prototype.recursiveRequire = function(path) {

    if (this.fs.statSync(path).isDirectory()) {

        var files = this.fs.readdirSync(path);
        var i = files.length;
        while(i--) {
            this.recursiveRequire(path+files[i]);
        }

    } else {
        require(path);
    }
};

/**
 * Run tests, which is basicly require all the application scripts and then
 * all the test scripts.
 * @return {void}
 */
Test.prototype.run = function() {
    this.recursiveRequire(this.scriptsPath);
    this.recursiveRequire(this.testsPath);
};

/**
 * Global assert Node.js module. See: http://nodejs.org/api/assert.html
 * This variable has to be global in order to be acessible within the
 * Node.js's require()
 * @type {object}
 */
assert = require("assert");

/**
 * Global sinon Node.js module. See: http://sinonjs.org/
 * This variable has to be global in order to be acessible within the
 * Node.js's require()
 * @type {object}
 */
try {
    sinon = require("sinon").sandbox.create();
} catch(err) {
    console.log(
        "You must have sinon module installed in order to run the JS tests." +
        "\nTry `$ npm install sinon`"
    ); throw 0;
}

/**
 * Actually instantiate the Test object and call run()
 * @type {Test}
 */
var testObject = new Test; testObject.run();
