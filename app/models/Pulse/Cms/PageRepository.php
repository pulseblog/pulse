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
     * Returns all the pages. Paginates results using the $pagination parameter
     * @param  integer $pagination Pagination value
     * @return Illuminate\Pagination\Paginator
     */
    public function all($pagination = 0)
    {
        $instance = App::make($this->domainObject);

        return $instance::paginate($pagination);
    }

    /**
     * Finds a Page by the given id
     * @param  integer $id Page id
     * @return Page A Page object or null.
     */
    public function find($id)
    {
        $instance = App::make($this->domainObject);

        return $instance::find($id);
    }

    /**
     * Finds a Page by the given id or throw exception
     * @param  integer $id Page id
     * @return Page A Page object or null.
     */
    public function findOrFail($id)
    {
        $instance = App::make($this->domainObject);

        return $instance::findOrFail($id);
    }

    /**
     * Finds a Page by the given slug
     * @param  string $slug Page slug
     * @return Page A Page object or null.
     */
    public function findBySlug($slug)
    {
        $instance = App::make($this->domainObject);

        return $instance::where('slug', $slug)->first();
    }

    /**
     * Create a new instance and persist at database.
     * @param  array       $input
     * @param  Object User $user
     * @return Pulse\Cms\Page instance
     */
    public function createNew($input, $user)
    {
        $page = App::make($this->domainObject);

        $page->title        = array_get($input, 'title');
        $page->slug         = array_get($input, 'slug');
        $page->lean_content = array_get($input, 'lean_content');
        $page->content      = array_get($input, 'content');
        $page->author_id    = $user->id;

        $page->save();
        return $page;
    }

    /**
     * Update a page resource given.
     * @param  int   $page_id
     * @param  array $input
     * @return null| Page Object
     */
    public function update($page_id, $input)
    {
        $page = $this->findOrFail($page_id);

        if ($page)
        {
            $page->title        = array_get($input, 'title');
            $page->slug         = array_get($input, 'slug');
            $page->lean_content = array_get($input, 'lean_content');
            $page->content      = array_get($input, 'content');

            $page->save();
        }

        return $page;
    }
}
