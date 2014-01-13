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
        $this->assertResponseOk();
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
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('find')
        ->with(123456)
        ->once()
        ->andReturn(new Page);

        App::instance('Pulse\Cms\PageRepository', $repository);

        $this->action('GET', 'Pulse\Backend\PagesController@show', ['id' => 123456]);
        $this->assertResponseOk();
    }

    public function testShouldNotGetToShowInexistent()
    {
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('find')
        ->with(123456)
        ->once()
        ->andReturn(null);

        Redirect::shouldReceive('back')
            ->once();

        App::instance('Pulse\Cms\PageRepository', $repository);

        $this->action('GET', 'Pulse\Backend\PagesController@show', ['id' => 123456]);
    }

    public function testShouldDestroyAPage()
    {
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('delete')
            ->once()
            ->with(123456)
            ->andReturn(true);

        App::instance('Pulse\Cms\PageRepository', $repository);

        $this->action('DELETE', 'Pulse\Backend\PagesController@destroy', ['id' => 123456]);
    }

    public function testShoulNotDestroyAPageIfDoesntExists()
    {
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('delete')
            ->once()
            ->with(123456)
            ->andReturn(false);

        App::instance('Pulse\Cms\PageRepository', $repository);

        Redirect::shouldReceive('action')
            ->with('Pulse\Backend\PagesController@index')
            ->once();

        $this->action('DELETE', 'Pulse\Backend\PagesController@destroy', ['id' => 123456]);
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
