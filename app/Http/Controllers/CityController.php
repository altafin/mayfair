<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(
        protected CityRepositoryInterface $cityRepository
    ) {}

    public function index(Request $request, $state)
    {
        $arrCities = $this->cityRepository->getAll($state);
        $pgInicial = ($request->qtdRegistros * $request->page) - $request->qtdRegistros;
        $pgFinal = ($request->qtdRegistros * $request->page) - 1;
        $pgFinal = ($pgFinal > count($arrCities) ? count($arrCities) - 1 : $pgFinal);
        $arrLista = array();
        for ($cnt = $pgInicial; $cnt <= $pgFinal; $cnt++) {
            if (!is_null($arrCities[$cnt])) {
                $arrCity = array(
                    'id' => $arrCities[$cnt]['id']
                , 'text' => $arrCities[$cnt]['name']
                );
                array_push($arrLista, $arrCity);
            }
        }
        $arrResult = array(
            'count_filtered' => count($arrCities),
            'incomplete_results' => false,
            'items' => $arrLista
        );
        echo json_encode($arrResult);
    }
}
