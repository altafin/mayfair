<?php

namespace App\Http\Controllers;

use App\DTO\Person\CreatePersonDTO;
use App\DTO\Person\UpdatePersonDTO;
use App\Http\Requests\StoreUpdatePersonRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function __construct(
        protected PersonService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $people = $this->service->getAll($request->filter);
        return view('admin.person.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.person.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdatePersonRequest $request)
    {
        $this->service->new($request);
        return redirect()->route('person.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$people = $this->service->findOne($id)) {
            return back();
        }
        return 'show'; //<--incluir view do show
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$person = $this->service->findOne($id)) {
            return back();
        }
        return view('admin.person.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdatePersonRequest $request, string $id)
    {
        dd($id);

        $person = $this->service->update($request);
        if (!$person) {
            return back();
        }
        return redirect()->route('person.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return redirect()->route('person.index');
    }
}
