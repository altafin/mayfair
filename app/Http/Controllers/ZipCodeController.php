<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\ZipCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ZipCodeController extends Controller
{
    public function search(Request $request)
    {
        $searchZipCode = $request->zip_code;
        //Checks if the postal code exists in the local base
        $result = ZipCode::with(['state', 'city'])->where('zip_code', $searchZipCode)->first();
        if (!$result) {
            //If you don't find it in the local database, search with the API
            $result = Http::get("viacep.com.br/ws/$searchZipCode/json/")->json();
            if (!array_key_exists('erro', $result)) {
                $state = State::where('abbreviation', $result['uf'])->first();
                $city = City::where('name', mb_strtolower($result['localidade']))->first();
                $arrZipCode = array(
                    'zip_code' => preg_replace('/[^0-9]/', '', $result['cep']),
                    'street' => $result['logradouro'],
                    'district' => $result['bairro'],
                    'city' => $result['localidade'],
                    'state' => $result['uf'],
                );
                $zipCode = new ZipCode();
                $zipCode->state()->associate($state);
                $zipCode->city()->associate($city);
                $zipCode->user()->associate(Auth::user());
                $zipCode->fill($arrZipCode);
                $zipCode->save();
                $arrZipCode['state'] = $state;
                $arrZipCode['city'] = $city;
                $result = $arrZipCode;
            }
        }
        return $result;
    }
}
