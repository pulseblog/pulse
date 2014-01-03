<?php namespace Pulse\Cms;

use App;

/**
 * Class PageRepository
 *
 * The Pulse\Cms\PageRepository abstracts all the database queries regarding
 * Pages.
 *
 * @package  Pulse\Cms
 */
class PageRepository
{
    /**
     * The domain object class that is going to query for using
     * Eloquent methods.
     * @var string
     */
    public $domainObject = 'Pulse\Cms\Page';

    /**
     * Finds a Page by the given id
     * @param  integer $id Page id
     * @return Page A Page object or null.
     */
    public function find($id)
    {
        $page = App::make($this->domainObject);

        return $page::find($id);
    }

    /**
     * Finds a Page by the given slug
     * @param  string $slug Page slug
     * @return Page A Page object or null.
     */
    public function findBySlug($slug)
    {
        $page = App::make($this->domainObject);

        return $page::where('slug', $slug)->first();
    }
}
