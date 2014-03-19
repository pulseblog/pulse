<?php

use Mockery as m;

/**
 * Feature: As an administrator I would like to manage the cms pages
 */
class ManagePagesTest extends AcceptanceTestCase {

    /**
     * Scenario: Index all existing pages
     * @return void
     */
    public function testViewPageList()
    {
        // Given
        $this->im_logged_in();

        // And
        $this->site_has_pages();

        // When
        $this->i_visit_url('admin/pages');

        // Then
        $this->i_should_see_page_list();
    }

    /**
     * Scenario: Create a new page
     * @return void
     */
    public function testShouldCreatePage()
    {
        // Given
        $this->im_logged_in();

        // And
        $this->i_visit_url('admin/pages/create');

        // Then
        $this->i_expect_to_save_the_post([
            'title' => 'A New Page',
            'slug' => 'a-new-page',
            'lean_content' => 'The lean content',
            'content' => 'The whole content',
        ]);

        // When
        $this->i_submit_form_with('form', [
            'title' => 'A New Page',
            'slug' => 'a-new-page',
            'lean_content' => 'The lean content',
            'content' => 'The whole content',
        ]);
    }

    /**
     * Mocks the Confide::user method in order to simulates that there is an
     * User logged in
     * @return void
     */
    protected function im_logged_in()
    {
        Confide::shouldReceive('user')
            ->andReturn(m::mock('Pulse\User\User'));
    }

    /**
     * Creates some sample pages and also mocks the PageRepository in order
     * to retrieve those sample pages
     * @return void
     */
    protected function site_has_pages()
    {
        // Definition
        $pages = array();
        $page = 1;

        $pages[0] = App::make('Pulse\Cms\Page');
        $pages[0]->title = 'Sample Page A';
        $pages[0]->slug = 'sample_page_a';
        $pages[0]->lean_content = 'a sample page a';
        $pages[0]->content = 'the sample page a';
        $pages[0]->author_id = 1;

        $pages[1] = App::make('Pulse\Cms\Page');
        $pages[1]->title = 'Sample Page B';
        $pages[1]->slug = 'sample_page_b';
        $pages[1]->lean_content = 'a sample page b';
        $pages[1]->content = 'the sample page b';
        $pages[1]->author_id = 1;

        $repo = m::mock('Pulse\Cms\PageRepository');

        // Expectations
        $repo->shouldReceive('all')
            ->once()
            ->andReturn($pages);

        App::instance('Pulse\Cms\PageRepository', $repo);
    }

    /**
     * Asserts if user sees the page list
     * @return void
     */
    protected function i_should_see_page_list()
    {
        $this->assertResponseOk();

        $this->assertContains('Sample Page A', $this->client->getResponse()->getContent());
        $this->assertContains('Sample Page B', $this->client->getResponse()->getContent());
    }

    protected function i_expect_to_save_the_post($postAttributes)
    {
        // Set
        $repo = m::mock('Pulse\Cms\PageRepository');

        // Expectation
        $repo->shouldReceive('createNew')
            ->once()
            ->andReturnUsing(function($realInput, $user) use ($postAttributes) {
                foreach ($postAttributes as $key => $value) {
                    if($postAttributes[$key] != $realInput[$key]) {
                        return false;
                    }
                }
                return new Pulse\Cms\Page;
            });

        App::instance('Pulse\Cms\PageRepository', $repo);
    }
}
