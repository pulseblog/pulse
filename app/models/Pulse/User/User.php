<?php namespace Pulse\User;

use Eloquent;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Confide\ConfideUser;

class User extends Eloquent implements ConfideUserInterface {
    use ConfideUser;
}
