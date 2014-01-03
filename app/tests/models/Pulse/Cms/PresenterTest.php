<?php namespace Pulse\Cms;

use TestCase;
use Mockery as m;

class PresenterTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldSetInstance()
    {
        $instance = m::mock('Pulse\Cms\Page');

        $presenter = new Presenter;

        $presenter->setInstance($instance);

        $this->assertEquals($instance, $presenter->instance);
    }
}
