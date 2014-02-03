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

    public function testShouldGetAll()
    {
        // Set
        $pagination = 2;
        $repo = new PageRepository;
        $page = m::mock('Pulse\Cms\Page');
        $pageCursor = [];

        // Expectations
        $page->shouldReceive('paginate')
            ->once()->with(2)
            ->andReturn($pageCursor);

        App::instance('Pulse\Cms\Page', $page);

        // Assertion
        $this->assertEquals($pageCursor, $repo->all($pagination));
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

    public function testShouldFindOrFail()
    {
        // Set
        $repo = new PageRepository;
        $page = m::mock('Pulse\Cms\Page');

        // Expectations
        $page->shouldReceive('findOrFail')
            ->once()->with(1)
            ->andReturn(m::self());

        App::instance('Pulse\Cms\Page', $page);

        // Assertion
        $this->assertEquals($page, $repo->findOrFail(1));
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

    public function testShouldCreateNew()
    {
        $input = [
            'title'     => 'true page',
            'slug'      => 'true_page',
            'content'   => 'asdsd',
            'author_id' => 123
        ];

        $user    = m::mock('Pulse\User\User');
        $newPage = m::mock('Pulse\Cms\Page[save]');

        $user->shouldReceive('getAttribute')
            ->once()
            ->andReturn(123);

        $newPage->shouldReceive('save')
            ->andReturn(m::self());

        App::instance('Pulse\Cms\Page', $newPage);

        $repo = new PageRepository;
        $repo->createNew($input, $user);
    }

    public function testShouldUpdateAPage()
    {
        // Set
        $input = [
            'title'     => 'true page',
            'slug'      => 'true_page',
            'content'   => 'asdsd',
            'author_id' => 123
        ];

        $repo = new PageRepository;
        $page = m::mock('Pulse\Cms\Page');
        $newPage = m::mock('Pulse\Cms\Page[save]');

        // Expectations
        $page->shouldReceive('findOrFail')
            ->once()->with(123)
            ->andReturn(m::self());

        App::instance('Pulse\Cms\Page', $page);

        $newPage->shouldReceive('save')
            ->andReturn(m::self());

        // Assertion
        $repo = new PageRepository;
        $repo->update(123, $input);
    }
}
