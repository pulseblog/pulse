<?php namespace Pulse\Backend;

use TestCase;
use Mockery as m;
use App, Confide, Lang;

class UserControllerTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldCreate()
    {
        // Request
        $this->action('GET', 'Pulse\Backend\UserController@create');

        // Assertion
        $this->assertResponseOk();
    }

    public function testShouldStore()
    {
        // Set
        $input = [
            'username' => 'Someone',
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'password_confirmation' => 'foobar1337'
        ];
        $repo = m::mock('Pulse\User\Repository');
        $resultingUser = App::make('Pulse\User\User');
        $resultingUser->id = 1;

        // Expectation
        $repo->shouldReceive('signup')
            ->with($input)->once()
            ->andReturn($resultingUser);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@store', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
    }

    public function testShouldNotStore()
    {
        // Set
        $input = [
            'username' => 'Someone',
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'password_confirmation' => 'foobar1337'
        ];
        $repo = m::mock('Pulse\User\Repository');
        $resultingUser = App::make('Pulse\User\User');
        $resultingUser->id = null; // Not saved successfully

        // Expectation
        $repo->shouldReceive('signup')
            ->with($input)->once()
            ->andReturn($resultingUser);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@store', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@create');
    }

    public function testShouldLogin()
    {
        // Request
        $this->action('GET', 'Pulse\Backend\UserController@login');

        // Assertion
        $this->assertResponseOk();
    }

    public function testShouldRedirectLoggedInsteadOfLogin()
    {
        // Expectation
        Confide::shouldReceive('user')
            ->once()
            ->andReturn(m::mock('Pulse\User\User'));

        // Request
        $this->action('GET', 'Pulse\Backend\UserController@login');

        // Assertion
        $this->assertRedirectedTo('/');
    }

    public function testShouldDoLogin()
    {
        // Set
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];
        $repo = m::mock('Pulse\User\Repository');

        // Expectation
        $repo->shouldReceive('login')
            ->with($input)->once()
            ->andReturn(true);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_login', [], $input);

        // Assertion
        $this->assertRedirectedTo('/');
    }

    public function testShouldNotLoginWithWrongCredentials()
    {
        // Set
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];
        $repo = m::mock('Pulse\User\Repository');

        // Expectation
        $repo->shouldReceive('login')
            ->with($input)->once()
            ->andReturn(false);

        $repo->shouldReceive('isThrottled','existsButNotConfirmed')
            ->andReturn(false);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_login', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
    }

    public function testShouldNotLoginThrottled()
    {
        // Set
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];
        $repo = m::mock('Pulse\User\Repository');

        // Expectation
        $repo->shouldReceive('login')
            ->with($input)->once()
            ->andReturn(false);

        $repo->shouldReceive('isThrottled')
            ->with($input)->once()
            ->andReturn(true);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_login', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
    }

    public function testShouldNotLoginNotConfirmed()
    {
        // Set
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];
        $repo = m::mock('Pulse\User\Repository');

        // Expectation
        $repo->shouldReceive('login')
            ->with($input)->once()
            ->andReturn(false);

        $repo->shouldReceive('isThrottled')
            ->with($input)
            ->andReturn(false);

        $repo->shouldReceive('existsButNotConfirmed')
            ->with($input)->once()
            ->andReturn(false);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_login', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
    }

    public function testShouldConfirm()
    {
        // Set
        $code = 'bacon';
        $wildcards = ['code' => $code];

        // Expectation
        Confide::shouldReceive('confirm')
            ->with($code)->once()
            ->andReturn(true);

        // Request
        $this->action('GET', 'Pulse\Backend\UserController@confirm', $wildcards);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
        $this->assertSessionHas('notice');
    }

    public function testShouldNotConfirm()
    {
        // Set
        $code = 'bacon';
        $wildcards = ['code' => $code];
        $errorMsg = Lang::get('confide::confide.alerts.wrong_confirmation');

        // Expectation
        Confide::shouldReceive('confirm')
            ->with($code)->once()
            ->andReturn(false);

        // Request
        $this->action('GET', 'Pulse\Backend\UserController@confirm', $wildcards);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
        $this->assertSessionHas('error', $errorMsg);
    }

    public function testShouldForgotPassword()
    {
        // Request
        $this->action('GET', 'Pulse\Backend\UserController@forgot_password');

        // Assertion
        $this->assertResponseOk();
    }

    public function testShouldDoForgotPassword()
    {
        // Set
        $email = 'someone@something.com';
        $input = ['email' => $email];

        // Expectation
        Confide::shouldReceive('forgotPassword')
            ->with($email)->once()
            ->andReturn(true);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_forgot_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
        $this->assertSessionHas('notice');
    }

    public function testShouldNotDoForgotPasswordWithWrongEmail()
    {
        // Set
        $email = 'someone@something.com';
        $input = ['email' => $email];
        $errorMsg = Lang::get('confide::confide.alerts.wrong_password_forgot');

        // Expectation
        Confide::shouldReceive('forgotPassword')
            ->with($email)->once()
            ->andReturn(false);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_forgot_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@forgot_password');
        $this->assertSessionHas('error', $errorMsg);
    }

    public function testShouldResetPassword()
    {
        // Set
        $wildcards = ['token'=>'123123'];

        // Request
        $this->action('GET', 'Pulse\Backend\UserController@reset_password', $wildcards);

        // Assertion
        $this->assertResponseOk();
    }

    public function testShouldDoResetPassword()
    {
        // Set
        $input = [
            'token' => '123123',
            'password' => 'foobar1337',
            'password_confirmation' => 'foobar1337',
        ];

        // Expectation
        Confide::shouldReceive('resetPassword')
            ->with($input)->once()
            ->andReturn(true);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_reset_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@login');
    }

    public function testShouldNotDoResetPasswordWrongToken()
    {
        // Set
        $input = [
            'token' => '123123',
            'password' => 'foobar1337',
            'password_confirmation' => 'foobar1337',
        ];

        // Expectation
        Confide::shouldReceive('resetPassword')
            ->with($input)->once()
            ->andReturn(false);

        // Request
        $this->action('POST', 'Pulse\Backend\UserController@do_reset_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UserController@reset_password', ['token'=>'123123']);
    }

    public function testShouldLogout()
    {
        // Expectations
        Confide::shouldReceive('logout')
            ->once();

        // Request
        $this->action('GET', 'Pulse\Backend\UserController@logout');

        // Assertion
        $this->assertRedirectedTo('/');
    }
}
