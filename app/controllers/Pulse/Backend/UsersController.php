<?php namespace Pulse\Backend;

use App, View, Input, Config, Redirect, Lang, Mail, Confide;
use Controller;

/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller {

    /**
     * Displays the form for account creation
     * @return Illuminate\Http\Response
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'));
    }

    /**
     * Stores new account
     * @return Illuminate\Http\Response
     */
    public function store()
    {
        $repo = App::make('Pulse\User\UserRepository');
        $user = $repo->signup(Input::all());

        if ($user->id)
        {
            Mail::send(Config::get('confide::email_account_confirmation'), compact('user'), function($message) use ($user) {
                $message
                    ->to($user->email, $user->username)
                    ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
            });

            return Redirect::action('Pulse\Backend\UsersController@login')
                ->with( 'notice', Lang::get('confide::confide.alerts.account_created') );
        }
        else
        {
            $error = $user->errors()->all(':message');

            return Redirect::action('Pulse\Backend\UsersController@create')
                ->withInput(Input::except('password'))
                ->with( 'error', $error );
        }
    }

    /**
     * Displays the login form
     * @return Illuminate\Http\Response
     */
    public function login()
    {
        if( Confide::user() )
        {
            return Redirect::to('/');
        }
        else
        {
            return View::make(Config::get('confide::login_form'));
        }
    }

    /**
     * Attempt to do login
     * @return Illuminate\Http\Response
     */
    public function do_login()
    {
        $repo = App::make('Pulse\User\UserRepository');
        $input = Input::all();

        if ($repo->login($input))
        {
            return Redirect::intended('/');
        }
        else
        {
            if ($repo->isThrottled($input))
            {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            }
            elseif ($repo->existsButNotConfirmed($input))
            {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            }
            else
            {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('Pulse\Backend\UsersController@login')
                ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt to confirm account with code
     * @param  string  $code
     * @return Illuminate\Http\Response
     */
    public function confirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('Pulse\Backend\UsersController@login')
                ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('Pulse\Backend\UsersController@login')
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Displays the forgot password form
     * @return Illuminate\Http\Response
     */
    public function forgot_password()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     * @return Illuminate\Http\Response
     */
    public function do_forgot_password()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('Pulse\Backend\UsersController@login')
                ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('Pulse\Backend\UsersController@forgot_password')
                ->withInput()
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Shows the change password form with the given token
     * @return Illuminate\Http\Response
     */
    public function reset_password( $token )
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     * @return Illuminate\Http\Response
     */
    public function do_reset_password()
    {
        $repo = App::make('Pulse\User\UserRepository');
        $input = array(
            'token'                 =>Input::get( 'token' ),
            'password'              =>Input::get( 'password' ),
            'password_confirmation' =>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( $repo->resetPassword( $input ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('Pulse\Backend\UsersController@login')
                ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('Pulse\Backend\UsersController@reset_password', array('token'=>$input['token']))
                ->withInput()
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Log the user out of the application.
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

}
