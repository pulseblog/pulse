<?php namespace Pulse\Backend;

use Controller, View, Input, Redirect;

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
        return View::make('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return View::make('pages.show');
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
            Redirect::back();

        return View::make('backend.pages.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
