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

        // Expectations
        $userMock->shouldReceive('checkUserExists')
            ->with($input)->once()
            ->andReturn(true);

        $userMock->shouldReceive('isConfirmed')
            ->with($input)->once()
            ->andReturn(false);

        App::instance('Pulse\User\User', $userMock);

        // Assertion
        $this->assertTrue($repo->existsButNotConfirmed($input));
    }
}
