<?php namespace Pulse\Backend;

use Controller, View, Input, Redirect, Confide, App, Session;
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

    /**
     * Injects dependencies into controller
     * @param PostRepository $repo
     */
    function __construct(PostRepository $repo)
    {
        $this->postRepository = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = Input::get('page', 0);

        $posts = $this->postRepository->all($page);

        return View::make('backend.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $post = App::make('Pulse\Cms\Post');
        return View::make('backend.posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $user = Confide::user();
        $input = Input::all();

        if (! $user)
            return Redirect::action('Pulse\Backend\PostsController@index');

        $post = $this->postRepository->createNew($input, $user);

        if (count($post->errors()) == 0) {
            $this->flash('create');
            return Redirect::action(
                        'Pulse\Backend\PostsController@edit',
                        ['id' => $post->id ]
                   );
        } else {
            return Redirect::action('Pulse\Backend\PostsController@create')
                ->withInput($input)
                ->withErrors($post->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $post = $this->postRepository->findOrFail($id);

        return View::make('backend.posts.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->findOrFail($id);

        return View::make('backend.posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        $post = $this->postRepository->update($id, $input);

        if (count($post->errors()) == 0) {
            $this->flash('update');
            return Redirect::action('Pulse\Backend\PostsController@edit', ['id' => $post->id ])
                ->withInput($input);
        } else {
            return Redirect::action('Pulse\Backend\PostsController@edit', ['id' => $post->id ])
                ->withInput($input)
                ->withErrors($post->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->postRepository->delete($id);

        $this->flash('delete');

        return Redirect::action('Pulse\Backend\PostsController@index');
    }

    protected function flash($action, $success = true, $resource = 'Post')
    {
        $append = ($success) ? '_success' : '_failed';

        Session::flash('success_alert', 'dialog.'.$action.$append);
    }
}
