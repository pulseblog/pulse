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
        $page->shouldReceive('find')->once()->andReturn(m::self());
        App::instance('Pulse\Cms\Page', $page);

        // Assertion
        $this->assertEquals($page, $repo->find(1));
    }
}
