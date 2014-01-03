<?php namespace Pulse\Cms;

use TestCase;
use Mockery as m;
use App;

class PageRepositoryTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldFind()
    {
        // Set
        $repo = new PageRepository;
        $page = m::mock('Pulse\Cms\Page');

        // Expectations
        $page->shouldReceive('find')
            ->once()->with(1)
            ->andReturn(m::self());

        App::instance('Pulse\Cms\Page', $page);

        // Assertion
        $this->assertEquals($page, $repo->find(1));
    }

    public function testShouldFindBySlug()
    {
        // Set
        $repo = new PageRepository;
        $page = m::mock('Pulse\Cms\Page');
        $slug = 'the_page_slug';

        // Expectations
        $page->shouldReceive('where')
            ->once()->with('slug',$slug)
            ->andReturn(m::self());

        $page->shouldReceive('first')
            ->once()->andReturn(m::self());

        App::instance('Pulse\Cms\Page', $page);

        // Assertion
        $this->assertEquals($page, $repo->findBySlug($slug));
    }
}
