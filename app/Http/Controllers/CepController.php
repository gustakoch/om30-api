<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CepController extends Controller
{
    public function getCep(Request $request)
    {
        if (!$request->query('search')) {
            return response()->json(['message' => 'Um CEP deve ser informando para realizar a consulta.'], 400);
        }

        $cep = $request->query('search');
        $redis = Redis::connection();
        $cachedCep = $redis->get('cep:'.$cep);

        if ($cachedCep) {
            return response()->json(json_decode($cachedCep));
        }

        try {
            $client = new Client();
            $response = $client->request('GET', "https://viacep.com.br/ws/{$cep}/json/");
            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                $jsonResponse = $response->getBody();
                $cepInfo = json_decode($jsonResponse);

                $redis->setex('cep:'.$cep, now()->addDay()->diffInSeconds(now()), $jsonResponse);

                return $cepInfo;
            } else {
                return response()->json(['message' => 'O CEP informado não foi localizado.'], 404);
            }
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
