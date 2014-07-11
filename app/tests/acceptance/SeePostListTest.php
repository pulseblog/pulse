<?php

use Mockery as m;

/**
 * Feature: As an user I would like to see the list of blog posts
 */
class SeePostListTest extends AcceptanceTestCase {

    /**
     * Scenario: Simply visit the home page or post list
     * @return void
     */
    public function testSimplyVisitPostList()
    {
        // Given
        $this->site_has_posts();

        // When
        $this->i_visit_url('/');

        // Then
        $this->i_should_see_post_list();

        // And
        $this->i_should_see_post_links();
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

        $repo     = m::mock('Pulse\Cms\PostRepository');
        $pageRepo = m::mock('Pulse\Cms\PageRepository');


        // Expectations
        $repo->shouldReceive('all')
            ->once()
            ->andReturn($posts);

        $pageRepo->shouldReceive('all')
            ->andReturn([]);

        App::instance('Pulse\Cms\PostRepository', $repo);
        App::instance('Pulse\Cms\PageRepository', $pageRepo);
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

    /**
     * Asserts if user sees links for the posts
     * @return void
     */
    protected function i_should_see_post_links()
    {
        $postAUrl = URL::action('Pulse\Frontend\CmsController@showPost', ['slug'=>'sample_post_a']);
        $postBUrl = URL::action('Pulse\Frontend\CmsController@showPost', ['slug'=>'sample_post_b']);

        $this->assertContains($postAUrl, $this->client->getResponse()->getContent());
        $this->assertContains($postBUrl, $this->client->getResponse()->getContent());
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
