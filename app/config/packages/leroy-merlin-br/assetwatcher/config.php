<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Files to watch
    |--------------------------------------------------------------------------
    |
    | For each key contained in the array 'files_to_watch' an anonymous
    | function must be declared. This function is performed by sending the
    | filename as a parameter whenever a file that matches the specified
    | key is modified.
    |
    */
    'files_to_watch' => array(

        '../*.less' => function($file) {

            // Compilling front.less --------------------------------
            echo "Compiling 'front.less'...\n";

            $cd = 'cd '.app_path().'/assets/less;';
            $from =  app_path().'/assets/less/front.less';
            $to = app_path().'/../public/assets/css/front.css';

            exec($cd.' lessc '.$from.' > '.$to);

            // Compilling admin.less --------------------------------
            echo "Compiling 'admin.less'...\n";

            $cd = 'cd '.app_path().'/assets/less;';
            $from =  app_path().'/assets/less/admin.less';
            $to = app_path().'/../public/assets/css/admin.css';

            exec($cd.' lessc '.$from.' > '.$to);
        },

    )
);
