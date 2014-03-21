<?php namespace Pulse\Backend;

use Controller, View, Input, Redirect, Confide, App;
use Pulse\Cms\PostRepository;

/**
 * PostsController Class
 *
 * CRUD Controller for the Pulse\Cms\Post resource.
 *
 * @package Pulse\Backend
 */
class PostsController extends Controller
{
    protected $postRepository;

    function __construct(PostRepository $repo)
    {
        $this->postRepository = $repo;
    }

    public function index()
    {
        $page = Input::get('page', 0);

        $posts = $this->postRepository->all($page);

        return View::make('backend.posts.index', compact('posts'));
    }
}
