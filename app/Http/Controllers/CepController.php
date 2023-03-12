<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function getCep(Request $request)
    {
        if (!$request->query('search')) {
            return response()->json(['message' => 'Um CEP deve ser informando para realizar a consulta.'], 400);
        }

        try {
            $client = new Client();
            $response = $client->request('GET', "https://viacep.com.br/ws/{$request->query('search')}/json/");
            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                $jsonResponse = $response->getBody();
                $cepInfo = json_decode($jsonResponse);

                return $cepInfo;
            } else {
                return response()->json(['message' => 'O CEP informado não foi localizado.'], 404);
            }
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
