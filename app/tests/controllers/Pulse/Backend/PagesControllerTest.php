<?php namespace Pulse\Backend;

use TestCase;
use Mockery as m;
use App, Confide, Lang;
use Pulse\Cms\Page;
use Redirect;

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
        $this->action('GET', 'Pulse\Backend\PagesController@create');

        $this->assertResponseOk();
    }

    public function testShouldGetEdit()
    {
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('find')
        ->with(123456)
        ->once()
        ->andReturn(new Page);

        App::instance('Pulse\Cms\PageRepository', $repository);

        $this->action('GET', 'Pulse\Backend\PagesController@edit', ['id' => 123456]);
    }

    public function testShouldNotGetInexistentEdit()
    {
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('find')
        ->with(123456)
        ->once()
        ->andReturn(null);

        Redirect::shouldReceive('back')
            ->once();

        App::instance('Pulse\Cms\PageRepository', $repository);

        $this->action('GET', 'Pulse\Backend\PagesController@edit', ['id' => 123456]);
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
