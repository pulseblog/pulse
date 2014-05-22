<?php

use Mockery as m;

/**
 * Feature: As an administrator I would like to manage the blog posts
 */
class ManagePostsTest extends AcceptanceTestCase {

    /**
     * Scenario: Index all existing posts
     * @return void
     */
    public function testViewPostList()
    {
        // Given
        $this->im_logged_in();

        // And
        $this->site_has_posts();

        // When
        $this->i_visit_url('admin/posts');

        // Then
        $this->i_should_see_post_list();
    }

    /**
     * Scenario: Create a new post
     * @return void
     */
    public function testShouldCreatePost()
    {
        // Given
        $this->im_logged_in();

        // And
        $this->i_visit_url('admin/posts/create');

        // Then
        $this->i_expect_to_create_the_post([
            'title' => 'A New Post',
            'slug' => 'a-new-post',
            'lean_content' => 'The lean content',
            'content' => 'The whole content',
        ]);

        // When
        $this->i_submit_form_with('form', [
            'title' => 'A New Post',
            'slug' => 'a-new-post',
            'lean_content' => 'The lean content',
            'content' => 'The whole content',
        ]);

        // And
        $this->i_should_be_redirected_to('admin/post/1/edit');
    }

    /**
     * Scenario: Edit an existing post
     * @return void
     */
    public function testShouldEditPost()
    {
        // Given
        $this->im_logged_in();

        // And
        $this->site_has_posts();

        // And
        $this->i_visit_url('admin/post/1/edit');

        // Then
        $this->i_expect_to_update_the_post(1, [
            'title' => 'Sample Post Edited',
            'slug' => 'a-new-post',
            'lean_content' => 'The lean content',
            'content' => 'The whole content',
        ]);

        // When
        $this->i_submit_form_with('form', [
            'title' => 'Sample Post Edited',
            'slug' => 'a-new-post',
            'lean_content' => 'The lean content',
            'content' => 'The whole content',
        ]);

        // And
        $this->i_should_be_redirected_to('admin/post/1/edit');
    }

    /**
     * Scenario: Destroy an existing post
     * @return void
     */
    public function testShouldDestroyPost()
    {
        // Given
        $this->im_logged_in();

        // And
        $this->site_has_posts();

        // And
        $this->i_visit_url('admin/post/1/edit');

        // Then
        $this->i_expect_to_delete_the_post(1);

        // When
        $this->i_click_the_link('a[method="delete"]');

        // And
        $this->i_should_be_redirected_to('admin/posts');
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
     * Creates some sample posts and also mocks the PostRepository in order
     * to retrieve those sample posts
     * @return void
     */
    protected function site_has_posts()
    {
        // Definition
        $posts = array();
        $post = 1;

        $posts[0] = App::make('Pulse\Cms\Post');
        $posts[0]->title = 'Sample Post A';
        $posts[0]->slug = 'sample_post_a';
        $posts[0]->lean_content = 'a sample post a';
        $posts[0]->content = 'the sample post a';
        $posts[0]->author_id = 1;
        $posts[0]->id = 1;

        $posts[1] = App::make('Pulse\Cms\Post');
        $posts[1]->title = 'Sample Post B';
        $posts[1]->slug = 'sample_post_b';
        $posts[1]->lean_content = 'a sample post b';
        $posts[1]->content = 'the sample post b';
        $posts[1]->author_id = 1;
        $posts[1]->id = 2;

        $repo = m::mock('Pulse\Cms\PostRepository');

        // Expectations
        $repo->shouldReceive('all')
            ->andReturn($posts);

        $repo->shouldReceive('findOrFail')
            ->with(1)
            ->andReturn($posts[0]);

        $repo->shouldReceive('findOrFail')
            ->with(2)
            ->andReturn($posts[1]);

        App::instance('Pulse\Cms\PostRepository', $repo);
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
     * Sets a expectation in the PostRepository to receive the 'createNew'
     * method
     * @param  array $postAttributes The attributes of the post
     * @return void
     */
    protected function i_expect_to_create_the_post($postAttributes)
    {
        // Set
        $repo = m::mock('Pulse\Cms\PostRepository');

        // Expectation
        $repo->shouldReceive('createNew')
            ->once()
            ->andReturnUsing(function($realInput, $user) use ($postAttributes) {
                foreach ($postAttributes as $key => $value) {
                    if($postAttributes[$key] != $realInput[$key]) {
                        return false;
                    }
                }

                $newPost = new Pulse\Cms\Post;
                $newPost->id = 1;

                return $newPost;
            });

        App::instance('Pulse\Cms\PostRepository', $repo);
    }

    /**
     * Sets a expectation in the PostRepository to receive the 'createNew'
     * method
     * @param  integer $postId The id of the post to expect
     * @param  array $postAttributes The attributes of the post
     * @return void
     */
    protected function i_expect_to_update_the_post($postId, $postAttributes)
    {
        // Set
        $repo = m::mock('Pulse\Cms\PostRepository');

        // Expectation
        $repo->shouldReceive('update')
            ->once()
            ->andReturnUsing(function($postId, $realInput) use ($postAttributes) {
                foreach ($postAttributes as $key => $value) {
                    if($postAttributes[$key] != $realInput[$key]) {
                        return false;
                    }
                }

                $newPost = new Pulse\Cms\Post;
                $newPost->id = 1;

                return $newPost;
            });

        App::instance('Pulse\Cms\PostRepository', $repo);
    }

    /**
     * Sets a expectation in the PostRepository to receive the 'delete'
     * method with the given id
     * @param  integer $postId The id of the post to expect
     * @return void
     */
    protected function i_expect_to_delete_the_post($postId)
    {
        // Set
        $repo = m::mock('Pulse\Cms\PostRepository');

        // Expectation
        $repo->shouldReceive('delete')
            ->once()
            ->with($postId);

        App::instance('Pulse\Cms\PostRepository', $repo);
    }
}
