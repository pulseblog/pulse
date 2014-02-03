<?php

use Mockery as m;

/**
 * Feature: As an user I would like to visit a cms page
 */
class SeePageTest extends AcceptanceTestCase {

    /**
     * Scenario: View rendered markdown of a Page
     * @return  void
     */
    public function testViewRenderedMarkdown()
    {
        // Given
        $this->site_has_page([
            'title' => 'Static Page With Markdown',
            'slug' => 'static_page_with_markdown',
            'lean_content' => 'A markdown filled page',
            'content' => 'A **markdown** _filled_ [page](#)',
            'author_id' => 1,
        ]);

        // When
        $this->i_visit_url('page-'.'static_page_with_markdown');

        // Then
        $this->i_should_see(
            'A <strong>markdown</strong> <em>filled</em> <a href="#">page</a>'
        );
    }

    /**
     * Create a sample page an also mocks the PageRepository in order to
     * be able to retrieve that page
     * @param  array $data Attributes of the Page
     * @return void
     */
    protected function site_has_page($data)
    {
        // Definition
        $page = App::make('Pulse\Cms\Page');

        foreach ($data as $key => $value) {
            $page->{$key} = $value;
        }

        $repo = m::mock('Pulse\Cms\PageRepository');

        // Expectations
        $repo->shouldReceive('findBySlug')
            ->once()->with($page->slug)
            ->andReturn($page);

        App::instance('Pulse\Cms\PageRepository', $repo);
    }

    /**
     * Closes mockery expectations
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }
}
