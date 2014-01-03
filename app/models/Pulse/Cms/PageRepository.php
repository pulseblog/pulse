<?php namespace Pulse\Cms;

use App;

/**
 * Class PageRepository
 *
 * The Pulse\Cms\PageRepository abstracts all the database queries regarding Pages.
 *
 * @package  Pulse\Cms
 */
class PageRepository
{

    /**
     * Finds a Page by the given id
     * @param  integer $id Page id
     * @return Page A Page object or null.
     */
    public function find($id)
    {
        $page = App::make('Pulse\Cms\Page');

        return $page::find($id);
    }
}
