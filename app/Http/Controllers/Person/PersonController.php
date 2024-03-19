<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePersonRequest;
use App\Models\State;
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
        $people = $this->personRepository->getPaginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter
        );

        $filters = ['filter' => $request->get('filter', '')];

        //$people = $this->personRepository->getPagination();
        //$people = $this->personRepository->getAll($request->filter);
        $model = $this->model;
        return view('admin.person.index', compact('people', 'model', 'filters'));

        //$model = ucfirst(explode('.', $request->route()->getName())[0]);
        //dd(get_class($this));
        //dd(get_parent_class($this));
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
        $states = State::all()->toArray();
        return view('admin.person.edit', compact('person', 'model', 'states'));
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

    public function select(Request $request)
    {

    }
}
