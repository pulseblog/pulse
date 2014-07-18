<?php namespace Pulse\Frontend;

use App, Input, View;
use Pulse\Base\BaseController;

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
         *
         * @var integer
         */
        $page  = Input::get('page', 0);
        $repo  = App::make('Pulse\Cms\PostRepository');
        $posts = $repo->all($page);

        return $this->render('posts.index', compact('posts'));
    }

    /**
     * Show a post by slug
     *
     * @param  string $slug The post slug
     * @return Illuminate\Http\Response
     */
    public function showPost($slug)
    {
        $repo = App::make('Pulse\Cms\PostRepository');

        $post = $repo->findBySlug($slug);

        if ($post) {
            $postPresenter = App::make('Pulse\Cms\Presenter');
            $postPresenter->setInstance($post);

            return $this->render('posts.show', compact('postPresenter', 'post'));
        } else {
            App::abort(404);
        }
    }

    /**
     * Show a page by slug
     *
     * @param  string $slug The page slug
     * @return Illuminate\Http\Response
     */
    public function showPage($slug)
    {
        $repo = App::make('Pulse\Cms\PageRepository');

        $page = $repo->findBySlug($slug);

        if ($page) {
            $pagePresenter = App::make('Pulse\Cms\Presenter');
            $pagePresenter->setInstance($page);

            return $this->render('pages.show', compact('pagePresenter'));
        } else {
            App::abort(404);
        }
    }
}
