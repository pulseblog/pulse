<?php namespace Pulse\Backend;

use Controller, View, Input, Redirect, Confide, App;

class PagesController extends Controller {

    protected $pageRepository;

    function __construct(\Pulse\Cms\PageRepository $repo)
    {
        $this->pageRepository = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = 0;

        if (Input::get('page'))
            $page = Input::get('page');

        $pages = $this->pageRepository->all($page);

        $params = [ 'pages' => $pages ];

        return View::make('backend.pages.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page = App::make('Pulse\Cms\Page');
        return View::make('backend.pages.create', ['page' => $page]);
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
            return Redirect::action('Pulse\Backend\PagesController@index');

        $page = $this->pageRepository->createNew($input, $user);

        if (! $page->errors()) {
            return Redirect::action('Pulse\Backend\PagesController@edit',
                        ['id' => $page->id ]
                   );
        } else {
            return Redirect::action('Pulse\Backend\PagesController@create')
                ->withInput($input)
                ->withErrors($page->errors());
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
        $page = $this->pageRepository->find($id);

        if (! $page)
            return Redirect::back();

        return View::make('backend.pages.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pageRepository->find($id);

        if (! $page)
            return Redirect::back();

        return View::make('backend.pages.edit', ['page' => $page]);
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

        $page = $this->pageRepository->update($id, $input);

        if (! $page->errors()) {
            return Redirect::action('Pulse\Backend\PagesController@edit', ['id' => $page->id ])
                ->withInput($input);
        } else {
            return Redirect::action('Pulse\Backend\PagesController@edit', ['id' => $page->id ])
                ->withInput($input)
                ->withErrors($page->errors());
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
        $deleted = $this->pageRepository->delete($id);

        return Redirect::action('Pulse\Backend\PagesController@index');
    }

}
