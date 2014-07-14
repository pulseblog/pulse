<?php namespace Pulse\User;

use TestCase;
use Mockery as m;
use App, Config, Confide;

class RepositoryTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldSignup()
    {
        // Set
        $repo = m::mock('Pulse\User\Repository[save]');
        $input = [
            'username' => 'Someone',
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'password_confirmation' => 'foobar1337'
        ];

        // Expectation
        $repo->shouldReceive('save')
            ->andReturnUsing(function($instance) {
                return
                    $instance->username == 'Someone' &&
                    $instance->email == 'someone@something.com';
            });

        // Assertion
        $this->assertInstanceOf('Pulse\User\User', $repo->signup($input));
    }

    public function testShouldLogin()
    {
        // Set
        $repo = App::make('Pulse\User\Repository');
        $identityColumns = ['email', 'username'];
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];

        // Expectation
        Confide::shouldReceive('logAttempt')
            ->with($input, Config::get('confide::signup_confirm'), $identityColumns)
            ->andReturn(true);

        // Assertion
        $this->assertTrue($repo->login($input));
    }

    public function testIsThrottled()
    {
        // Set
        $repo = App::make('Pulse\User\Repository');
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];

        // Expectation
        Confide::shouldReceive('isThrottled')
            ->with($input)->once()
            ->andReturn(true);

        // Assertion
        $this->assertTrue($repo->isThrottled($input));
    }

    public function testExistsButNotConfirmed()
    {
        // Set
        $repo = App::make('Pulse\User\Repository');
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];
        $userMock = m::mock('user');
        $userMock->confirmed = null;

        // Expectations
        Confide::shouldReceive('getUserByEmailOrUsername')
            ->with($input)->once()
            ->andReturn($userMock);

        // Assertion
        $this->assertTrue($repo->existsButNotConfirmed($input));
    }

    public function testNotExistsAndNotConfirmed()
    {
        // Set
        $repo = App::make('Pulse\User\Repository');
        $input = [
            'email' => 'someone@something.com',
            'password' => 'foobar1337',
            'remember'=> true
        ];

        // Expectations
        Confide::shouldReceive('getUserByEmailOrUsername')
            ->with($input)->once()
            ->andReturn(null);

        // Assertion
        $this->assertNull($repo->existsButNotConfirmed($input));
    }

    public function testShouldResetPassword()
    {
        // Set
        $repo = App::make('Pulse\User\Repository');
        $token = '1234';
        $userMock = m::mock('Pulse\User\User[save]');
        $input = [
            'token' =>  $token,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        // Expectations
        Confide::shouldReceive('userByResetPasswordToken')
            ->with($token)->once()
            ->andReturn($userMock);

        $userMock->shouldReceive('save')
            ->once()
            ->andReturnUsing(function() use ($userMock) {
                return $userMock->password == 'secret' &&
                    $userMock->password_confirmation == 'secret';
            });

        // Assertion
        $this->assertTrue($repo->resetPassword($input));
    }

    public function testShouldSave()
    {
        // Set
        $repo = App::make('Pulse\User\Repository');
        $userMock = m::mock('Pulse\User\User');

        // Expectations
        $userMock->shouldReceive('save')
            ->once()
            ->andReturn(true);

        // Assertion
        $this->assertTrue($repo->save($userMock));
    }
}
