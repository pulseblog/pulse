<?php namespace Pulse\Cms;

/**
 * Post Class
 *
 * The Post class is the Domain Object that represents a blog post entry.
 * It extends the Pulse\Cms\Page since the blog post have the same behavior
 * that cms pages have.
 *
 * @package Pulse\Cms
 */
class Post extends Page
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';
}
