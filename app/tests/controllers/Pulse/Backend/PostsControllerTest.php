<?php namespace Pulse\Backend;

use TestCase;
use Mockery as m;
use App, Confide, Lang;
use Pulse\Cms\Post;
use Redirect;

class PostsControllerTest extends TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testShouldGetIndex()
    {
        // Set
        $posts = [];
        $repository = m::mock('Pulse\Cms\PostRepository');

        // Expectation
        $repository->shouldReceive('all')
            ->once()
            ->andReturn($posts);

        App::instance('Pulse\Cms\PostRepository', $repository);

        // Assertion
        $this->action('GET', 'Pulse\Backend\PostsController@index');
        $this->assertResponseOk();
    }

    public function testShouldGetCreate()
    {
        // Assertion
        $this->action('GET', 'Pulse\Backend\PostsController@create');
        $this->assertResponseOk();
    }

    public function testShouldGetEdit()
    {
        // Set
        $repository = m::mock('Pulse\Cms\PostRepository');
        $post = App::make('Pulse\Cms\Post');

        // Expectation
        $repository->shouldReceive('findOrFail')
        ->with(123456)
        ->once()
        ->andReturn($post);

        App::instance('Pulse\Cms\PostRepository', $repository);

        // Assertion
        $this->action('GET', 'Pulse\Backend\PostsController@edit', ['id' => 123456]);
        $this->assertResponseOk();
    }

    public function testShouldGetShow()
    {
        // Set
        $repository = m::mock('Pulse\Cms\PostRepository');
        $post = App::make('Pulse\Cms\Post');

        // Expectation
        $repository->shouldReceive('findOrFail')
        ->with(123456)
        ->once()
        ->andReturn(new Post);

        App::instance('Pulse\Cms\PostRepository', $repository);

        // Assertion
        $this->action('GET', 'Pulse\Backend\PostsController@show', ['id' => 123456]);
        $this->assertResponseOk();
    }

    public function testShouldDestroy()
    {
        // Set
        $repository = m::mock('Pulse\Cms\PostRepository');

        // Expectation
        $repository->shouldReceive('delete')
            ->once()
            ->with(123456)
            ->andReturn(true);

        App::instance('Pulse\Cms\PostRepository', $repository);

        // Assertion
        $this->action('DELETE', 'Pulse\Backend\PostsController@destroy', ['id' => 123456]);
        $this->assertRedirectedToAction('Pulse\Backend\PostsController@index');
    }

    public function testShouldStoreAPost()
    {
        // Set
        $user = m::mock('Pulse\User\User');
        $post = m::mock('Pulse\Cms\Post[errors]');
        $post->id = 1;
        $post->shouldReceive('errors')
            ->once()
            ->andReturn([]);

        $input = [
            'title' => 'true post',
            'slug'  => 'true_post',
        ];

        // Expectation
        Confide::shouldReceive('user')
            ->andReturn($user)
            ->once();

        $repository = m::mock('Pulse\Cms\PostRepository');

        $repository->shouldReceive('createNew')
            ->with($input, $user)
            ->once()
            ->andReturn($post);

        App::instance('Pulse\Cms\PostRepository', $repository);

        // Assertion
        $this->action('POST', 'Pulse\Backend\PostsController@store', $input);
        $this->assertRedirectedToAction(
            'Pulse\Backend\PostsController@edit',
            ['id' => $post->id ]
        );
    }

    public function testShouldNotStoreAInvalidPost()
    {
        // Set
        $user = m::mock('Pulse\User\User');
        $post = m::mock('Pulse\Cms\Post');
        $post->shouldReceive('errors')
            ->twice()
            ->andReturn(['messsage' => 'wrong']);

        $input = [
            'title' => 'true post',
            'slug'  => 'true_post',
        ];

        // Expectation
        Confide::shouldReceive('user')
            ->andReturn($user)
            ->once();

        $repository = m::mock('Pulse\Cms\PostRepository');

        $repository->shouldReceive('createNew')
            ->with($input, $user)
            ->once()
            ->andReturn($post);

        App::instance('Pulse\Cms\PostRepository', $repository);

        // Assertion
        $this->action('POST', 'Pulse\Backend\PostsController@store', $input);
        $this->assertRedirectedToAction(
            'Pulse\Backend\PostsController@create'
        );
    }

    public function testShouldUpdateAPost()
    {
        // Set
        $post = m::mock('Pulse\Cms\Post[errors]');
        $post->shouldReceive('errors')
            ->once()
            ->andReturn([]);

        $input = [
            'title' => 'true post',
            'slug'  => 'true_post',
        ];

        // Expectation
        $repository = m::mock('Pulse\Cms\PostRepository');

        $repository->shouldReceive('update')
            ->with(123, $input)
            ->once()
            ->andReturn($post);

        App::instance('Pulse\Cms\PostRepository', $repository);

        // Assertion
        $this->action('PUT', 'Pulse\Backend\PostsController@update', ['id' => 123 ], $input);
        $this->assertRedirectedToAction(
            'Pulse\Backend\PostsController@edit',
            ['id' => $post->id ]
        );
    }
}
