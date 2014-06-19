<?php namespace Pulse\Base;

use Illuminate\Routing\Controller;
use App;

/**
 * BaseController Class
 *
 * Contains the common behavior for Pulse controllers
 *
 * @package Pulse\Base
 */
abstract class BaseController extends Controller {

    /**
     * The response manager that is going to be used in order to prepare
     * action responses
     *
     * @var \Pulse\Base\ResponseManager
     */
    protected $responseManager = null;

    /**
     * Sets the responseManager attribute of the controller
     */
    public function __construct()
    {
        $this->responseManager = App::make('Pulse\Base\ResponseManager');
    }

    /**
     * Make a view using the attached ResponseManager object
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return Illuminate\Support\Contracts\RenderableInterface a renderable View or Response object
     */
    protected function render($view, $data = array(), $mergeData = array())
    {
        return $this->responseManager->render($view, $data, $mergeData);
    }

    /**
     * Create a new redirect response to the given path.
     *
     * @param  string  $path
     * @param  int     $status
     * @param  array   $headers
     * @param  bool    $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function goToUrl($path, $status = 302, $headers = array(), $secure = null)
    {
        return $this->responseManager->goToUrl($path, $status, $headers, $secure);
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param  string  $action
     * @param  array   $parameters
     * @param  int     $status
     * @param  array   $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function goToAction($action, $parameters = array(), $status = 302, $headers = array())
    {
        return $this->responseManager->goToAction($action, $parameters, $status, $headers);
    }
}
