<?php namespace Pulse\Base;

use App;

class ResponseManager {

    /**
     *
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return Illuminate\Support\Contracts\RenderableInterface a renderable View or Response object
     */
    public function render($view, $data = array(), $mergeData = array())
    {
        $response = App::make('view')
            ->make($view, $data);

        return $response;
    }
}
