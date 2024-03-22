<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\ZipCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZipCodeController extends Controller
{
    public function search(Request $request)
    {
        $searchZipCode = $request->zip_code;
        //Checks if the postal code exists in the local base
        $result = ZipCode::with('state')->where('zip_code', $searchZipCode)->first();
        if (!$result) {
            //If you don't find it in the local database, search with the API
            $result = Http::get("viacep.com.br/ws/$searchZipCode/json/")->json();
            if (!array_key_exists('erro', $result)) {
                $state = State::where('abbreviation', $result['uf'])->first();
                $arrZipCode = array(
                    'zip_code' => preg_replace('/[^0-9]/', '', $result['cep']),
                    'street' => $result['logradouro'],
                    'district' => $result['bairro'],
                    'city' => $result['localidade'],
                    'state' => $result['uf'],
                );
                $state->zipCodes()->create($arrZipCode);
                $arrZipCode['state'] = $state;
                $result = $arrZipCode;
            }
        }
        return $result;
    }
}
