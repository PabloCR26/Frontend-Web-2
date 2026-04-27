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

    public function index()
    {
        $token = session('access_token');

        if (!$token) {
            return redirect()->route('login');
        }

        if (auth()->user()->role_id == 3) {
            return redirect()->route('solicitudes.index')->with('error', 'No tienes permisos para acceder a la bitácora de viajes.');
        }

        try {
            $response = $this->client->get('/api/trips', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $viajes = $body['data']['data'] ?? $body['data'] ?? [];

            return view('viajes.index', compact('viajes')); 
        } catch (\Throwable $e) {
            return redirect()->route('solicitudes.index')->with('error', 'No se pudieron cargar los viajes.');
        }
    }

    public function create(Request $request)
    {
        $token = session('access_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $requestId = $request->request_id;

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
                    'observations'       => $request->observation, 
                ]
            ]);

            return redirect()
                ->route('solicitudes.index')
                ->with('success', 'Viaje iniciado correctamente. Vehículo en ruta.');

        } catch (ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            $statusCode = $e->getResponse()->getStatusCode();
            
            $errorMsg = $responseBody['error'] ?? $responseBody['message'] ?? 'Error al iniciar el viaje.';
            
            if ($statusCode === 422) {
                return redirect()->back()
                    ->withErrors($responseBody['errors'] ?? [])
                    ->with('error', $errorMsg)->withInput();
            }

            return redirect()->back()->with('error', $errorMsg)->withInput();
        }
    }

    public function edit($id)
    {
        $token = session('access_token');

        if (auth()->user()->role_id == 3) {
            return redirect()->route('solicitudes.index')->with('error', 'No tienes permisos para registrar devoluciones.');
        }

        try {
            $response = $this->client->get("/api/trips/{$id}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            $viaje = $body['data'] ?? $body;

            return view('viajes.edit', compact('viaje'));

        } catch (\Throwable $e) {
            return redirect()->route('viajes.index')
                ->with('error', 'No se pudo cargar la información del viaje.');
        }
    }

    public function update(Request $request, $id)
    {
        $token = session('access_token');

        if (auth()->user()->role_id == 3) {
            return redirect()->route('solicitudes.index')->with('error', 'No tienes permisos para registrar devoluciones.');
        }

        $request->validate([
            'km_return'   => 'required|numeric|min:0',
            'observation' => 'nullable|string',
        ]);

        try {
            $this->client->put("/api/trips/{$id}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'km_return'   => $request->km_return,
                    'observation' => $request->observation,
                ]
            ]);

            return redirect()->route('viajes.index')
                ->with('success', 'Vehículo devuelto correctamente. Viaje finalizado.');

        } catch (ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            $statusCode = $e->getResponse()->getStatusCode();
            
            $errorMsg = $responseBody['error'] ?? $responseBody['message'] ?? 'Error al registrar la devolución.';

            if ($statusCode === 422) {
                return redirect()->back()
                    ->withErrors($responseBody['errors'] ?? [])
                    ->with('error', $errorMsg)->withInput();
            }

            return redirect()->back()->with('error', $errorMsg)->withInput();
        }
    }
}