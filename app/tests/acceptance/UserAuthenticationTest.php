<?php

use Mockery as m;

/**
 * Feature: As an admin I would like to be able to login into the application
 */
class UserAuthenticationTest extends AcceptanceTestCase {

    /**
     * Scenario: Login into the application
     * @return void
     */
    public function testShouldLogin()
    {
        // Given
        $this->site_has_user([
            'username' => 'Someone',
            'email' => 'someone@somewhere.com',
            'password' => 'foobarl337'
        ]);

        // Then
        $this->i_expect_to_become_logged_as([
            'email' => 'someone@somewhere.com',
            'password' => 'foobarl337'
        ]);

        // When
        $this->i_visit_url('users/login');

        // And
        $this->i_submit_form_with('form', [
            'email' => 'someone@somewhere.com',
            'password' => 'foobarl337'
        ]);
    }

    /**
     * Create a sample user
     * @param  array $data Attributes of the Post
     * @return void
     */
    protected function site_has_user($data)
    {
        // Definition
        $post = App::make('Pulse\User\User');

        foreach ($data as $key => $value) {
            $post->{$key} = $value;
        }
    }

    protected function i_expect_to_become_logged_as($input)
    {
        // Definition
        $repo = m::mock('Pulse\User\Repository');

        // Expectation
        $repo->shouldReceive('login')
            ->once()
            ->andReturnUsing(function($realInput) use ($input) {
                foreach ($input as $key => $value) {
                    if($input[$key] != $realInput[$key]) {
                        return false;
                    }
                }
                return true;
            });

        App::instance('Pulse\User\Repository', $repo);
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
