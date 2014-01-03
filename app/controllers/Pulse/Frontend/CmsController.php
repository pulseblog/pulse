<?php namespace Pulse\Frontend;

use App, Input;
use BaseController;

/**
 * CmsController Class
 *
 * This controller implements the CMS actions of the visitors (Frontend).
 *
 * @package  Pulse\Frontend
 */
class CmsController extends BaseController
{
    /**
     * Displays the blog post index for the given page
     * @return Illuminate\Http\Response
     */
    public function indexPosts()
    {
        /**
         * The page
         * @var integer
         */
        $page = Input::get('page', 1);

        $repo = App::make('Pulse\Cms\PostRepository');

        $posts = $repo->all($page);

        return 'something';
    }

    /**
     * Show a post by slug
     * @param  string $slug The post slug
     * @return Illuminate\Http\Response
     */
    public function showPost($slug)
    {
        $repo = App::make('Pulse\Cms\PostRepository');

        $post = $repo->findBySlug($slug);

        if ($post) {
            return 'something';
        } else {
            App::abort(404);
        }
    }

    /**
     * Show a page by slug
     * @param  string $slug The page slug
     * @return Illuminate\Http\Response
     */
    public function showPage($slug)
    {
        $repo = App::make('Pulse\Cms\PageRepository');

        $page = $repo->findBySlug($slug);

        if ($page) {
            return 'something';
        } else {
            App::abort(404);
        }
    }
}
