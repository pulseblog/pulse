<?php

use Mockery as m;

class CmsControllerTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldShowPage()
    {
        // Definitions
        $slug = 'the_post_slug';
        $page = m::mock('Pulse\Cms\Page');
        $repo = m::mock('Pulse\Cms\PageRepository');

        // Expectations
        $repo->shouldReceive('findBySlug')
            ->once()->with($slug)
            ->andReturn($page)
            ->getMock();

        App::instance('Pulse\Cms\PageRepository', $repo);

        // Request
        $this->action('GET', 'CmsController@showPage', ['slug'=>$slug]);

        // Assertion
        $this->assertTrue($this->client->getResponse()->isOk());
    }
}
