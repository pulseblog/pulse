<?php

use Mockery as m;

/**
 * Feature: As an user I would like to see a blog post
 */
class SeePostTest extends AcceptanceTestCase {

    /**
     * Scenario: Simply view a blog post
     * @return  void
     */
    public function testSimplyVisitPost()
    {
        // Given
        $this->site_has_a_post([
            'title' => 'Sample Post',
            'slug' => 'sample_post_slug',
            'lean_content' => 'a sample post',
            'content' => 'the sample post full content',
            'author_id' => 1,
        ]);

        // When
        $this->i_visit_url('sample_post_slug');

        // Then
        $this->i_should_see('the sample post full content');
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
