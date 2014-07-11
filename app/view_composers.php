<?php

/*
|--------------------------------------------------------------------------
| View Composers
|--------------------------------------------------------------------------
| View composers are callbacks or class methods that are called when a view
| is rendered. If you have data that you want bound to a given view each
| timethat view is rendered throughout your application, a view composer
| can organize that code into a single location.
|
*/

if (app()->environment() != 'testing') {

    View::composer('front.templates.main', function($view) {

        $pages = Cache::remember('pages', 1, function() {
            $pageRepo = App::make('Pulse\Cms\PageRepository');
            return $pageRepo->all()->flatten();
        });

        $view->with('pages', $pages);
    });

}

