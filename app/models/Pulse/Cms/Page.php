<?php namespace Pulse\Cms;

use Pulse\Base\DomainObject;

/**
 * Page Class
 *
 * The Page class is the Domain Object that represents a cms page.
 *
 * @package Pulse\Cms
 */
class Page extends DomainObject
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';
}
