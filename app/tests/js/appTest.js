/**
 * TestSuite for App (app.js)
 */
describe('App', function() {

    var app = null;

    beforeEach(function() {
        app = new App;
    });

    afterEach(function() {
        // "Closes" the mocks
        sinon.restore();
    })

    describe('#init()', function() {
        it('init() should call and return this.run()', function() {
            // Expectation
            app.run = sinon.mock()
                .once()
                .returns(true);

            // Assertion
            assert.equal(true, app.init());
            sinon.verify();
        })
    });

    describe('#getDynamicDom()', function() {
        it('getDynamicDom() should return [data-module] elements', function() {
            // Set
            var elements = [];

            // Expectation
            $ = sinon.mock()
                .once().withArgs('[data-module]')
                .returns(elements);

            // Assertion
            assert.equal(elements, app.getDynamicDom());
            sinon.verify();
        });
    });

    describe('#run()', function() {
        it('should iterate trought elements and call initModule()', function() {
            // Set
            var elements = {};
            var el = {};
            var $el = {'data-module': 'Foo Bar'};

            // Expectation
            app.getDynamicDom = sinon.mock()
                .once().returns(elements);

            elements.each = sinon.mock()
                .once().callsArgWith(0, 0, el);

            $ = sinon.mock()
                .once().withArgs(el).returns($el);

            $el.attr = sinon.mock()
                .once().withArgs('data-module')
                .returns($el['data-module']);

            app.initModule = sinon.mock()
                .once().withArgs($el, ['Bar', 'Foo']);

            // Assertion
            app.run();
            sinon.verify();
        });
    });

    describe('#initModule()', function() {
        it('should call each constructor given passing the $el as parameter', function() {
            // Set
            var moduleNames = ['Foo', 'Bar'];
            var $el = {};
            window = {};

            // Expectation
            window.Foo = sinon.mock()
                .once().withArgs($el)
                .returns({});

            window.Bar = sinon.mock()
                .once().withArgs($el)
                .returns({});

            // Assertion
            app.initModule($el, moduleNames);
            sinon.verify();
        });

        it('should throw exception if constructor did not exist', function() {
            // Set
            var moduleNames = ['DontExists'];
            var $el = {};
            if (typeof window === 'undefined') window = {};

            // Assertion
            assert.throws(function() {
                app.initModule($el, moduleNames);
            });
        });
    });

    describe('#log()', function() {
        it('should abstract window.console.log()', function() {
            // Set
            window = {console:{}};

            // Expectation
            window.console.log = sinon.mock()
                .once().withArgs('foobar');

            // Assertion
            assert.doesNotThrow(function(){
                app.log('foobar')
            });
            sinon.verify();
        });
    });
})
