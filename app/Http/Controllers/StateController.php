<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\StateRepositoryInterface;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct(
        protected StateRepositoryInterface $stateRepository
    ) {}

    public function index(Request $request)
    {
        $arrStates = $this->stateRepository->getAll();
        $pgInicial = ($request->qtdRegistros * $request->page) - $request->qtdRegistros;
        $pgFinal = ($request->qtdRegistros * $request->page) - 1;
        $pgFinal = ($pgFinal > count($arrStates) ? count($arrStates) - 1 : $pgFinal);
        $arrLista = array();
        for ($cnt = $pgInicial; $cnt <= $pgFinal; $cnt++) {
            if (!is_null($arrStates[$cnt])) {
                $arrState = array(
                    'id' => $arrStates[$cnt]['id']
                    , 'text' => $arrStates[$cnt]['name']
                    , 'region' => $arrStates[$cnt]['region']['name']
                );
                array_push($arrLista, $arrState);
            }
        }
        $arrResult = array(
            'count_filtered' => count($arrStates),
            'incomplete_results' => false,
            'items' => $arrLista
        );
        echo json_encode($arrResult);
    }
}
