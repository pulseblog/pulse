<?php namespace Pulse\Frontend;

use TestCase;
use Mockery as m;
use App;

class CmsControllerTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldIndexPosts()
    {
        // Definitions
        $pagination  = 2;
        $postsCursor = [];
        $repo        = m::mock('Pulse\Cms\PostRepository');

        // Expectations
        $repo->shouldReceive('all')
            ->once()->with($pagination)
            ->andReturn($postsCursor);

        App::instance('Pulse\Cms\PostRepository', $repo);

        // Request
        $this->action('GET', 'Pulse\Frontend\CmsController@indexPosts', ['page'=>$pagination]);

        // Assertion
        $this->assertResponseOk();
    }

    public function testShouldShowPost()
    {
        // Definitions
        $slug = 'the_post_slug';
        $repo = m::mock('Pulse\Cms\PostRepository');
        $post = App::make('Pulse\Cms\Post');
        $post->slug = $slug;

        // Expectations
        $repo->shouldReceive('findBySlug')
            ->once()->with($slug)
            ->andReturn($post)
            ->getMock();

        App::instance('Pulse\Cms\PostRepository', $repo);

        // Request
        $this->action('GET', 'Pulse\Frontend\CmsController@showPost', ['slug'=>$slug]);

        // Assertion
        $this->assertResponseOk();
    }

    public function testShouldShowPage()
    {
        // Definitions
        $slug = 'the_page_slug';
        $repo = m::mock('Pulse\Cms\PageRepository');
        $page = App::make('Pulse\Cms\Page');
        $page->slug = $slug;

        // Expectations
        $repo->shouldReceive('findBySlug')
            ->once()->with($slug)
            ->andReturn($page)
            ->getMock();

        App::instance('Pulse\Cms\PageRepository', $repo);

        // Request
        $this->action('GET', 'Pulse\Frontend\CmsController@showPage', ['slug'=>$slug]);

        // Assertion
        $this->assertResponseOk();
    }
}
