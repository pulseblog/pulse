<?php namespace Pulse\Backend;

use TestCase;
use Mockery as m;
use App, Confide, Lang;

class PagesControllerTest extends TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testShouldGetIndex()
    {
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('all')
            ->once()
            ->andReturn(m::mock('_cursor'));

        App::instance('Pulse\Cms\PageRepository', $repository);

        $this->action('GET', 'Pulse\Backend\PagesController@index');

        $this->assertResponseOk();
    }

    public function testShouldGetCreate()
    {
        # code...
    }

    public function testShouldGetEdit()
    {
        # code...
    }

    public function testShouldGetShow()
    {
        # code...
    }

    public function testShouldDestroyAPage()
    {

    }

    public function testShouldStoreAPage()
    {
        # code...
    }

    public function testShouldUpdateAPage()
    {
        # code...
    }
}
