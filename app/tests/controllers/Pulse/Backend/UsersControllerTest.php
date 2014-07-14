<?php namespace Pulse\Backend;

use TestCase;
use Mockery as m;
use App, Confide, Lang, Mail;

class UsersControllerTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldCreate()
    {
        // Request
        $this->action('GET', 'Pulse\Backend\UsersController@create');

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

        Mail::shouldReceive('send')
            ->once()
            ->andReturnUsing(function($a, $b, $closure){
                $message = m::mock('MailMessage');

                $message->shouldReceive('to')
                    ->once()
                    ->andReturn($message);

                $message->shouldReceive('subject');

                $closure($message);
            });

        // Request
        $this->action('POST', 'Pulse\Backend\UsersController@store', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
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
        $this->action('POST', 'Pulse\Backend\UsersController@store', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@create');
    }

    public function testShouldLogin()
    {
        // Request
        $this->action('GET', 'Pulse\Backend\UsersController@login');

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
        $this->action('GET', 'Pulse\Backend\UsersController@login');

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
        $this->action('POST', 'Pulse\Backend\UsersController@do_login', [], $input);

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
        $this->action('POST', 'Pulse\Backend\UsersController@do_login', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
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
        $this->action('POST', 'Pulse\Backend\UsersController@do_login', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
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
        $this->action('POST', 'Pulse\Backend\UsersController@do_login', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
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
        $this->action('GET', 'Pulse\Backend\UsersController@confirm', $wildcards);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
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
        $this->action('GET', 'Pulse\Backend\UsersController@confirm', $wildcards);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
        $this->assertSessionHas('error', $errorMsg);
    }

    public function testShouldForgotPassword()
    {
        // Request
        $this->action('GET', 'Pulse\Backend\UsersController@forgot_password');

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
        $this->action('POST', 'Pulse\Backend\UsersController@do_forgot_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
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
        $this->action('POST', 'Pulse\Backend\UsersController@do_forgot_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@forgot_password');
        $this->assertSessionHas('error', $errorMsg);
    }

    public function testShouldResetPassword()
    {
        // Set
        $wildcards = ['token'=>'123123'];

        // Request
        $this->action('GET', 'Pulse\Backend\UsersController@reset_password', $wildcards);

        // Assertion
        $this->assertResponseOk();
    }

    public function testShouldDoResetPassword()
    {
        // Set
        $repo = m::mock('Pulse\User\Repository[resetPassword]');
        $input = [
            'token' => '123123',
            'password' => 'foobar1337',
            'password_confirmation' => 'foobar1337',
        ];

        // Expectation
        $repo->shouldReceive('resetPassword')
            ->with($input)->once()
            ->andReturn(true);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UsersController@do_reset_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@login');
    }

    public function testShouldNotDoResetPasswordWrongToken()
    {
        // Set
        $repo = m::mock('Pulse\User\Repository[resetPassword]');
        $input = [
            'token' => '123123',
            'password' => 'foobar1337',
            'password_confirmation' => 'foobar1337',
        ];

        // Expectation
        $repo->shouldReceive('resetPassword')
            ->with($input)->once()
            ->andReturn(false);

        App::instance('Pulse\User\Repository', $repo);

        // Request
        $this->action('POST', 'Pulse\Backend\UsersController@do_reset_password', [], $input);

        // Assertion
        $this->assertRedirectedToAction('Pulse\Backend\UsersController@reset_password', ['token'=>'123123']);
    }

    public function testShouldLogout()
    {
        // Expectations
        Confide::shouldReceive('logout')
            ->once();

        // Request
        $this->action('GET', 'Pulse\Backend\UsersController@logout');

        // Assertion
        $this->assertRedirectedTo('/');
    }
}
