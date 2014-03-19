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
        // Set
        $pages = [];
        $repository = m::mock('Pulse\Cms\PageRepository');

        // Expectation
        $repository->shouldReceive('all')
            ->once()
            ->andReturn($pages);

        App::instance('Pulse\Cms\PageRepository', $repository);

        // Assertion
        $this->action('GET', 'Pulse\Backend\PagesController@index');
        $this->assertResponseOk();
    }

    public function testShouldGetCreate()
    {
        // Assertion
        $this->action('GET', 'Pulse\Backend\PagesController@create');
        $this->assertResponseOk();
    }

    public function testShouldGetEdit()
    {
        // Set
        $repository = m::mock('Pulse\Cms\PageRepository');
        $page = App::make('Pulse\Cms\Page');

        // Expectation
        $repository->shouldReceive('findOrFail')
        ->with(123456)
        ->once()
        ->andReturn($page);

        App::instance('Pulse\Cms\PageRepository', $repository);

        // Assertion
        $this->action('GET', 'Pulse\Backend\PagesController@edit', ['id' => 123456]);
        $this->assertResponseOk();
    }

    public function testShouldGetShow()
    {
        // Set
        $repository = m::mock('Pulse\Cms\PageRepository');
        $page = App::make('Pulse\Cms\Page');

        // Expectation
        $repository->shouldReceive('findOrFail')
        ->with(123456)
        ->once()
        ->andReturn(new Page);

        App::instance('Pulse\Cms\PageRepository', $repository);

        // Assertion
        $this->action('GET', 'Pulse\Backend\PagesController@show', ['id' => 123456]);
        $this->assertResponseOk();
    }

    public function testShouldDestroy()
    {
        // Set
        $repository = m::mock('Pulse\Cms\PageRepository');

        // Expectation
        $repository->shouldReceive('delete')
            ->once()
            ->with(123456)
            ->andReturn(true);

        App::instance('Pulse\Cms\PageRepository', $repository);

        // Assertion
        $this->action('DELETE', 'Pulse\Backend\PagesController@destroy', ['id' => 123456]);
        $this->assertRedirectedToAction('Pulse\Backend\PagesController@index');
    }

    public function testShouldStoreAPage()
    {
        // Set
        $user = m::mock('Pulse\User\User');
        $page = m::mock('Pulse\Cms\Page[errors]');
        $page->id = 1;
        $page->shouldReceive('errors')
            ->once()
            ->andReturn([]);

        $input = [
            'title' => 'true page',
            'slug'  => 'true_page',
        ];

        // Expectation
        Confide::shouldReceive('user')
            ->andReturn($user)
            ->once();

        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('createNew')
            ->with($input, $user)
            ->once()
            ->andReturn($page);

        App::instance('Pulse\Cms\PageRepository', $repository);

        // Assertion
        $this->action('POST', 'Pulse\Backend\PagesController@store', $input);
        $this->assertRedirectedToAction(
            'Pulse\Backend\PagesController@edit',
            ['id' => $page->id ]
        );
    }

    public function testShouldNotStoreAInvalidPage()
    {
        // Set
        $user = m::mock('Pulse\User\User');
        $page = m::mock('Pulse\Cms\Page');
        $page->shouldReceive('errors')
            ->twice()
            ->andReturn(['messsage' => 'wrong']);

        $input = [
            'title' => 'true page',
            'slug'  => 'true_page',
        ];

        // Expectation
        Confide::shouldReceive('user')
            ->andReturn($user)
            ->once();

        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('createNew')
            ->with($input, $user)
            ->once()
            ->andReturn($page);

        App::instance('Pulse\Cms\PageRepository', $repository);

        // Assertion
        $this->action('POST', 'Pulse\Backend\PagesController@store', $input);
        $this->assertRedirectedToAction(
            'Pulse\Backend\PagesController@create'
        );
    }

    public function testShouldUpdateAPage()
    {
        // Set
        $page = m::mock('Pulse\Cms\Page[errors]');
        $page->shouldReceive('errors')
            ->once()
            ->andReturn([]);

        $input = [
            'title' => 'true page',
            'slug'  => 'true_page',
        ];

        // Expectation
        $repository = m::mock('Pulse\Cms\PageRepository');

        $repository->shouldReceive('update')
            ->with(123, $input)
            ->once()
            ->andReturn($page);

        App::instance('Pulse\Cms\PageRepository', $repository);

        // Assertion
        $this->action('PUT', 'Pulse\Backend\PagesController@update', ['id' => 123 ], $input);
        $this->assertRedirectedToAction(
            'Pulse\Backend\PagesController@edit',
            ['id' => $page->id ]
        );
    }
}
