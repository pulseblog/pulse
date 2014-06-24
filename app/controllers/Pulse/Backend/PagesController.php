<?php namespace Pulse\Backend;

use Pulse\Base\BaseController;
use View, Input, Redirect, Confide, App;
use Pulse\Cms\PageRepository;

/**
 * PagesController Class
 *
 * CRUD Controller for Pulse\Cms\Page resource.
 *
 * @package Pulse\Backend
 */
class PagesController extends BaseController {

    protected $pageRepository;

    /**
     * Injects dependencies into controller
     * @param PageRepository $repo
     */
    function __construct(PageRepository $repo)
    {
        parent::__construct();

        $this->pageRepository = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = Input::get('page', 0);

        $pages = $this->pageRepository->all($page);

        return $this->render('backend.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page = App::make('Pulse\Cms\Page');
        return $this->render('backend.pages.create', compact('page'));
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
            return $this->goToAction('Pulse\Backend\PagesController@index');

        $page = $this->pageRepository->createNew($input, $user);

        if (count($page->errors()) == 0) {
            return $this->goToAction(
                        'Pulse\Backend\PagesController@edit',
                        ['id' => $page->id ]
                   );
        } else {
            return $this->goToAction('Pulse\Backend\PagesController@create')
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
        $page = $this->pageRepository->findOrFail($id);

        return $this->render('backend.pages.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pageRepository->findOrFail($id);

        return $this->render('backend.pages.edit', ['page' => $page]);
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
            return $this->goToAction('Pulse\Backend\PagesController@edit', ['id' => $page->id ])
                ->withInput($input);
        } else {
            return $this->goToAction('Pulse\Backend\PagesController@edit', ['id' => $page->id ])
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

        return $this->goToAction('Pulse\Backend\PagesController@index');
    }

}
