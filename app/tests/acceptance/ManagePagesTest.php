<?php

use Mockery as m;

/**
 * Feature: As an administrator I would like to manage the cms pages
 */
class ManagePagesTest extends AcceptanceTestCase {

    /**
     * Scenario: Index all existing posts
     * @return void
     */
    public function testViewPostList()
    {
        // Given
        $this->site_has_posts();

        // When
        $this->i_visit_url('admin/pages');

        // Then
        $this->i_should_see_post_list();
    }

    /**
     * Creates some sample posts and also mocks the PostRepository in order
     * to retrieve those sample posts
     * @return void
     */
    protected function site_has_posts()
    {
        // Definition
        $posts = array();
        $page = 1;

        $posts[0] = App::make('Pulse\Cms\Post');
        $posts[0]->title = 'Sample Post A';
        $posts[0]->slug = 'sample_post_a';
        $posts[0]->lean_content = 'a sample post a';
        $posts[0]->content = 'the sample post a';
        $posts[0]->author_id = 1;

        $posts[1] = App::make('Pulse\Cms\Post');
        $posts[1]->title = 'Sample Post B';
        $posts[1]->slug = 'sample_post_b';
        $posts[1]->lean_content = 'a sample post b';
        $posts[1]->content = 'the sample post b';
        $posts[1]->author_id = 1;

        $repo = m::mock('Pulse\Cms\PageRepository');

        // Expectations
        $repo->shouldReceive('all')
            ->once()
            ->andReturn($posts);

        App::instance('Pulse\Cms\PageRepository', $repo);
    }

    /**
     * Asserts if user sees the post list
     * @return void
     */
    protected function i_should_see_post_list()
    {
        $this->assertResponseOk();

        $this->assertContains('Sample Post A', $this->client->getResponse()->getContent());
        $this->assertContains('Sample Post B', $this->client->getResponse()->getContent());
    }
}
