<?php namespace Pulse\Base;

use App;
use Request;
use Redirect;
use Input;

/**
 * ResponseManager Class
 *
 * Handle the response creation.
 *
 * @package Pulse\Base
 */
class ResponseManager {

    /**
     * Builds a response using the view and the given data. It will primarily
     * render the $view file with the $data, but if the request asks for Json
     * A Json response with the same $data will be returned.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return Illuminate\Support\Contracts\RenderableInterface a renderable View or Response object
     */
    public function render($view, $data = array(), $mergeData = array())
    {
        if (Request::wantsJson() || Input::get('json',false)) {
            $response = App::make('response')
                ->json($data);
        } else {
            $response = App::make('response')
                ->view($view, $data);
        }

        return $response;
    }

    /**
     * Builds a redirect response to the given path.
     *
     * @param  string  $path
     * @param  int     $status
     * @param  array   $headers
     * @param  bool    $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    public function goToUrl($path, $status = 302, $headers = array(), $secure = null)
    {
        $response = App::make('redirect')
            ->to($path, $status, $headers, $secure);

        return $response;
    }
}
