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
        $responseFacade = m::mock();
        $params = ['foo'=>'bar'];

        // Expectation
        $responseFacade->shouldReceive('view')
            ->with('name.of.file', $params)
            ->andReturn('<div>RenderedView</div>');

        App::instance('Response', $responseFacade);

        // Assertion
        $result = $manager->render('name.of.file', $params);
        $this->assertEquals('<div>RenderedView</div>', $result);
    }

    public function testShouldRenderJson()
    {
        // Set
        $manager = m::mock('Pulse\Base\ResponseManager[morphToArray]');
        $manager->shouldAllowMockingProtectedMethods();
        $responseFacade = m::mock();
        $params = ['foo'=>'bar'];

        // Expectation
        Request::shouldReceive('wantsJson')
            ->andReturn(true);

        $manager->shouldReceive('morphToArray')
            ->with($params)
            ->once()
            ->andReturn(array_merge($params, ['morph'=>true]));

        $responseFacade->shouldReceive('json')
            ->with(['foo'=>'bar', 'morph'=>true])
            ->andReturn(json_encode($params));

        App::instance('Response', $responseFacade);

        // Assertion
        $result = $manager->render('name.of.file', $params);
        $this->assertEquals('{"foo":"bar"}', $result);
    }

    public function testShouldGoToUrl()
    {
        // Set
        $manager = App::make('Pulse\Base\ResponseManager');
        $redirectFacade = m::mock();
        $status = 302;
        $headers = ['foo'=>'bar'];

        // Expectation
        $redirectFacade->shouldReceive('to')
            ->once()
            ->with('path/to/go', $status, $headers, null)
            ->andReturn('SampleRedirect');

        App::instance('redirect', $redirectFacade);

        // Assertion
        $result = $manager->goToUrl('path/to/go', $status, $headers);
        $this->assertEquals('SampleRedirect', $result);
    }

    public function testShouldGoToAction()
    {
        // Set
        $manager = App::make('Pulse\Base\ResponseManager');
        $redirectFacade = m::mock();
        $parameters = ['something'=>'else'];
        $status = 302;
        $headers = ['foo'=>'bar'];

        // Expectation
        $redirectFacade->shouldReceive('action')
            ->once()
            ->with('Somewhere@action', $parameters, $status, $headers)
            ->andReturn('SampleActionRedirect');

        App::instance('redirect', $redirectFacade);

        // Assertion
        $result = $manager->goToAction('Somewhere@action', $parameters, $status, $headers);
        $this->assertEquals('SampleActionRedirect', $result);
    }

    public function testShouldMorphToArray()
    {
        // Set
        $manager = App::make('Pulse\Base\ResponseManager');
        $obj1 = m::mock('Illuminate\Support\Contracts\ArrayableInterface');
        $obj2 = m::mock('Illuminate\Support\Contracts\ArrayableInterface');
        $json = [
            'objects' => [
                $obj1,
                $obj2
            ]
        ];

        // Expectation
        $obj1->shouldReceive('toArray')
            ->once()
            ->andReturn(['name'=>'obj1']);

        $obj2->shouldReceive('toArray')
            ->once()
            ->andReturn(['name'=>'obj2']);

        // Assertion
        $this->assertEquals(
            [
                'objects' => [
                    ['name'=>'obj1'],
                    ['name'=>'obj2']
                ]
            ],
            $this->callProtected($manager,'morphToArray', [$json])
        );
    }
}
