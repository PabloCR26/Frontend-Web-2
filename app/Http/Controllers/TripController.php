<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\StoreTripRequest;

class TripController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.academy_api.url'),
            'timeout'  => 10,
        ]);
    }

    // 🔹 FORM CREATE
    public function create(Request $request)
    {
        $token = session('access_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $requestId = $request->request_id;

        // SOLICITUDES
        $response = $this->client->get("/api/vehicle-requests", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        $solicitudes = $body['data']['data'] ?? [];

        $solicitud = collect($solicitudes)->firstWhere('id', $requestId);

        if (!$solicitud) {
            return redirect()
                ->route('solicitudes.index')
                ->with('error', 'Solicitud no encontrada');
        }

        if ($solicitud['status'] !== 'approved') {
            return redirect()
                ->route('solicitudes.index')
                ->with('error', 'La solicitud no está aprobada');
        }

        // RUTAS
        $responseRutas = $this->client->get("/api/routes", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ]
        ]);

        $dataRutas = json_decode($responseRutas->getBody()->getContents(), true);
        $rutas = $dataRutas['data']['data'] ?? [];

        return view('viajes.create', compact('solicitud', 'rutas'));
    }

    // STORE (JSON)
    public function store(StoreTripRequest $request)
    {
        $token = session('access_token');

        try {

            $this->client->post('/api/trips', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ],
                'json' => [ 
                    'vehicle_id'         => $request->vehicle_id,
                    'user_id'            => $request->user_id,
                    'route_id'           => $request->route_id,
                    'km_departure'       => $request->km_departure,
                    'departure_datetime' => $request->departure_datetime,
                    'observations'        => $request->observation, 

                ]
            ]);

            return redirect()
                ->route('solicitudes.index')
                ->with('success', 'Viaje iniciado correctamente');

        }catch (ClientException $e) {

    dd(json_decode(
        $e->getResponse()->getBody()->getContents(),
        true
    ));
}
    }
}