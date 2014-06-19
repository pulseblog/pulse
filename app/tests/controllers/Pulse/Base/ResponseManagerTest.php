<?php namespace Pulse\Base;

use TestCase;
use Mockery as m;
use App;
use Request;

class ResponseManagerTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldRenderView()
    {
        // Set
        $manager = App::make('Pulse\Base\ResponseManager');
        $responseFacade = m::mock('response');
        $params = ['foo'=>'bar'];

        // Expectation
        $responseFacade->shouldReceive('view')
            ->with('name.of.file', $params)
            ->andReturn('<div>RenderedView</div>');

        App::instance('response', $responseFacade);

        // Assertion
        $result = $manager->render('name.of.file', $params);
        $this->assertEquals('<div>RenderedView</div>', $result);
    }

    public function testShouldRenderJson()
    {
        // Set
        $manager = App::make('Pulse\Base\ResponseManager');
        $responseFacade = m::mock('response');
        $params = ['foo'=>'bar'];

        // Expectation
        Request::shouldReceive('wantsJson')
            ->andReturn(true);

        $responseFacade->shouldReceive('json')
            ->with($params)
            ->andReturn(json_encode($params));

        App::instance('response', $responseFacade);

        // Assertion
        $result = $manager->render('name.of.file', $params);
        $this->assertEquals('{"foo":"bar"}', $result);
    }
}