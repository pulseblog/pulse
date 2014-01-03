<?php namespace Pulse\Cms;

use App;

/**
 * Class PageRepository
 *
 * The Pulse\Cms\PageRepository abstracts all the database queries regarding
 * Posts.
 *
 * @package  Pulse\Cms
 */
class PostRepository extends PageRepository
{
    /**
     * The domain object class that is going to query for using
     * Eloquent methods.
     * @var string
     */
    public $domainObject = 'Pulse\Cms\Post';
}
