<?php namespace Pulse\Cms;

/**
 * Class Presenter
 *
 * The Presenter service has the responsability of rendering the given Page/Post
 * domain object.
 *
 * @package  Pulse\Cms
 */
class Presenter
{
    /**
     * The page to be presented
     * @var Page
     */
    public $instance = null;

    /**
     * Sets the instance that is going to be presented.
     * @param  Page   $instance Page or post to be presented
     * @return void
     */
    public function setInstance(Page $instance)
    {
        $this->instance = $instance;
    }
}
