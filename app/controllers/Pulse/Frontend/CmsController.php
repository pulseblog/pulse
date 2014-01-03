<?php namespace Pulse\Frontend;

use App;
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
     * @param  integer $page The page
     * @return Illuminate\Http\Response
     */
    public function index($page = 1)
    {

    }

    /**
     * Show a post by slug
     * @param  string $slug The post slug
     * @return Illuminate\Http\Response
     */
    public function showPost($slug)
    {

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
