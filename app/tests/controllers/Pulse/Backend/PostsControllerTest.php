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
}
