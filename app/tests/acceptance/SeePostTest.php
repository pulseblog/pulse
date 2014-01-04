<?php

use Mockery as m;

/**
 * Feature: As an user I would like to see a blog post
 */
class SeePostTest extends AcceptanceTestCase {

    /**
     * Scenario: View rendered markdown of a Post
     * @return  void
     */
    public function testViewRenderedMarkdown()
    {
        // Given
        $this->site_has_a_post([
            'title' => 'Post With Markdown',
            'slug' => 'post_with_markdown',
            'lean_content' => 'A markdown filled post',
            'content' => 'A **markdown** _filled_ [post](#)',
            'author_id' => 1,
        ]);

        // When
        $this->i_visit_url('post_with_markdown');

        // Then
        $this->i_should_see(
            'A <strong>markdown</strong> <em>filled</em> <a href="#">post</a>'
        );
    }

    /**
     * Create a sample post an also mocks the PostRepository in order to
     * be able to retrieve that post
     * @param  array $data Attributes of the Post
     * @return void
     */
    protected function site_has_a_post($data)
    {
        // Definition
        $post = App::make('Pulse\Cms\Post');

        foreach ($data as $key => $value) {
            $post->{$key} = $value;
        }

        $repo = m::mock('Pulse\Cms\PostRepository');

        // Expectations
        $repo->shouldReceive('findBySlug')
            ->once()->with($post->slug)
            ->andReturn($post);

        App::instance('Pulse\Cms\PostRepository', $repo);
    }
}
