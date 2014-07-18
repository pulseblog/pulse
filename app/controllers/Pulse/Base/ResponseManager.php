<?php namespace Pulse\Base;

use App;
use Config;
use Request;
use Redirect;
use Input;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\ArrayableInterface;

/**
 * ResponseManager Class
 *
 * Handle the response creation.
 *
 * @package Pulse\Base
 */
class ResponseManager {

    /**
     * Name of the template that is going to be used when rendering view.
     * The template name will be appended to the $view variable received
     * in the render method
     * @var string
     */
    public $template;

    /**
     * Sets the template
     */
    public function __construct()
    {
        if (! Request::is('admin/*'))
            $this->template = Config::get('pulse.template', 'front');
    }

    /**
     * Builds a response using the view and the given data. It will primarily
     * render the $view file with the $data, but if the request asks for Json
     * A Json response with the same $data will be returned.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $viewData Data that will be passed to the View only, so it will not be visible in Json responses
     * @return Illuminate\Support\Contracts\RenderableInterface a renderable View or Response object
     */
    public function render($view, $data = array(), $viewData = array())
    {
        if (Request::wantsJson() || Input::get('json',false)) {
            $response = App::make('Response')
                ->json($this->morphToArray($data));
        } else {
            $response = App::make('Response')
                ->view($this->template.'.'.$view, array_merge($data, $viewData));
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

    /**
     * Builds a redirect response to a controller action.
     *
     * @param  string  $action
     * @param  array   $parameters
     * @param  int     $status
     * @param  array   $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    public function goToAction($action, $parameters = array(), $status = 302, $headers = array())
    {
        $response = App::make('redirect')
            ->action($action, $parameters, $status, $headers);

        return $response;
    }

    /**
     * Morph the given content into Array.
     *
     * @param  mixed   $content
     * @return string
     */
    protected function morphToArray($content)
    {
        if ($content instanceof ArrayableInterface || method_exists($content, 'toArray'))
            return $content->toArray();

        if (is_array($content)) {
            foreach($content as $key => $value) {
                $content[$key] = $this->morphToArray($value);
            }
        }

        return $content;
    }
}
