<?php namespace Pulse\Base;

use TestCase;
use Mockery as m;
use App;

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
        $view = m::mock('view');
        $params = ['foo'=>'bar'];

        // Expectation
        $view->shouldReceive('make')
            ->with('name.of.file', $params)
            ->andReturn('<div>RenderedView</div>');

        App::instance('view', $view);

        // Assertion
        $result = $manager->render('name.of.file', $params);
        $this->assertEquals('<div>RenderedView</div>', $result);
    }
}
