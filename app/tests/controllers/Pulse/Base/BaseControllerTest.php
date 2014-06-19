<?php namespace Pulse\Base;

use TestCase;
use Mockery as m;
use App;

class BaseControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->responseManager = m::mock('Pulse\Base\ResponseManager');
        App::instance('Pulse\Base\ResponseManager', $this->responseManager);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testShouldRender()
    {
        // Set
        $controller = new _StubController;
        $view      = 'view.name';
        $data      = ['foo'=>'bar'];
        $mergeData = ['some'=>'thing'];

        // Expectation
        $this->responseManager->shouldReceive('render')
            ->once()
            ->with($view, $data, $mergeData)
            ->andReturn('SampleResponse');

        // Assertion
        $response = $this->callProtected(
            $controller, 'render', [$view, $data, $mergeData]
        );

        $this->assertEquals('SampleResponse', $response);
    }

    public function testShouldGoToUrl()
    {
        // Set
        $controller = new _StubController;
        $path = 'path/to/go';
        $status = '302';
        $headers = ['foo'=>'bar'];
        $secure = null;

        // Expectation
        $this->responseManager->shouldReceive('goToUrl')
            ->once()
            ->with($path, $status, $headers, $secure)
            ->andReturn('SampleResponse');

        // Assertion
        $response = $this->callProtected(
            $controller, 'goToUrl', [$path, $status, $headers, $secure]
        );

        $this->assertEquals('SampleResponse', $response);
    }

    public function testShouldGoToAction()
    {
        // Set
        $controller = new _StubController;
        $action = 'Something@action';
        $parameters = ['something'=>'else'];
        $status = 302;
        $headers = ['foo'=>'bar'];

        // Expectation
        $this->responseManager->shouldReceive('goToAction')
            ->once()
            ->with($action, $parameters, $status, $headers)
            ->andReturn('SampleResponse');

        // Assertion
        $response = $this->callProtected(
            $controller, 'goToAction', [$action, $parameters, $status, $headers]
        );

        $this->assertEquals('SampleResponse', $response);
    }
}

class _StubController extends BaseController {}
