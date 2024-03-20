<?php

namespace App\Http\Controllers\Person;

use App\Enums\ContactType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePersonRequest;
use App\Models\City;
use App\Models\Person\Contact;
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
        $model = $this->model;
        return view('admin.person.index', compact('people', 'model', 'filters'));
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
        $states = $cities = null;
        $email = $phone = $cell = $website = null;
        if(count($person->addresses) > 0) {
            $states = State::all()->toArray();
            $cities = City::where('state_id', $person->addresses[0]['state'])->get()->toArray();
        }
        if(count($person->contacts) > 0) {
            foreach ($person->contacts as $contact) {
                switch ($contact['contact_type_id']) {
                    case ContactType::EMAIL:
                        $email = $contact['value'];
                        break;
                    case ContactType::PHONE:
                        $phone = $contact['value'];
                        break;
                    case ContactType::CELL:
                        $cell = $contact['value'];
                        break;
                    case ContactType::WEBSITE:
                        $website = $contact['value'];
                        break;
                }
            }
        }
        return view('admin.person.edit', compact('person', 'model', 'states', 'cities',
            'email', 'phone', 'cell', 'website'));
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
