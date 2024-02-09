<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePersonRequest;
use App\Repositories\Contracts\PersonRepositoryInterface;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    private $model;
    public function __construct(
        protected PersonRepositoryInterface $personRepository
    ) {
        $model = explode( '\\', get_class($this));
        $model = strtolower(array_pop($model));
        $this->model = ucfirst(str_replace('controller', '', $model));
    }

    public function index(Request $request)
    {
        //$model = ucfirst(explode('.', $request->route()->getName())[0]);
        //dd(get_class($this));
        //dd(get_parent_class($this));
        $people = $this->personRepository->getAll($request->filter);
        $model = $this->model;
        return view('admin.person.index', compact('people', 'model'));
    }

    public function create()
    {
        $model = $this->model;
        return view('admin.person.create', compact('model'));
    }

    public function edit(string $id)
    {
        if (!$person = $this->personRepository->findOne($id)) {
            return back();
        }
        $model = $this->model;
        return view('admin.person.edit', compact('person', 'model'));
    }

    public function store(StoreUpdatePersonRequest $request)
    {
        $this->personRepository->new($request, $this->model);
        return redirect()->route(strtolower($this->model) . '.index');
    }

    public function update(StoreUpdatePersonRequest $request, string $id)
    {
        $person = $this->personRepository->update($request, $id);
        if (!$person) {
            return back();
        }
        return redirect()->route(strtolower($this->model) . '.index');
    }






//    public function __construct(
//        protected PersonService $service
//    ) {}
//
//    /**
//     * Display a listing of the resource.
//     */
//    public function index(Request $request)
//    {
//        $people = $this->service->getAll($request->filter);
//        return view('admin.person.index', compact('people'));
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     */
//    public function create()
//    {
//        return view('admin.person.create');
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     */
//    public function store(StoreUpdatePersonRequest $request)
//    {
//        $this->service->new($request);
//        return redirect()->route('person.index');
//    }
//
//    /**
//     * Display the specified resource.
//     */
//    public function show(string $id)
//    {
//        if (!$people = $this->service->findOne($id)) {
//            return back();
//        }
//        return 'show'; //<--incluir view do show
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     */
//    public function edit(string $id)
//    {
//        if (!$person = $this->service->findOne($id)) {
//            return back();
//        }
//        return view('admin.person.edit', compact('person'));
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(StoreUpdatePersonRequest $request, string $id)
//    {
//        dd($id);
//
//        $person = $this->service->update($request);
//        if (!$person) {
//            return back();
//        }
//        return redirect()->route('person.index');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(string $id)
//    {
//        $this->service->delete($id);
//        return redirect()->route('person.index');
//    }
}
