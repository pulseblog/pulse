<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Test Connection
    |--------------------------------------------------------------------------
    |
    | With Sqlite, we can set the database connection to :memory:,
    | which will drastically speed up our tests, due to the database
    | not existing on the hard disk. Moreover, the production/development
    | database will never be populated with left-over test data, because
    | the connection, :memory:, always begins with an empty database.
    | In short: an in-memory database allows for fast and clean tests.
    |
    */
    'default' => 'sqlite',

    'connections' => array(
        'sqlite' => array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => ''
        ),
    )
);
