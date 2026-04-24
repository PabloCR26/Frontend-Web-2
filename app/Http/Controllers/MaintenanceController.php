<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;

class MaintenanceController extends Controller
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

        try {
            $response = $this->client->get('/api/maintenances', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $mantenimientos = $data['data'] ?? [];

            return view('mantenimientos.index', compact('mantenimientos'));
            
        } catch (\Throwable $e) {
            session()->flash('error', 'Error al conectar con la API.');
            return view('mantenimientos.index', ['mantenimientos' => []]);
        }
    }

    public function create()
    {
        $token = session('access_token');

        try {
            $response = $this->client->get('/api/vehicles', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $vehiculos = $data['data']['data'] ?? $data['data'] ?? [];

            return view('mantenimientos.create', compact('vehiculos'));
            
        } catch (\Throwable $e) {
            return redirect()->route('mantenimientos.index')->with('error', 'No se pudieron cargar los vehículos.');
        }
    }

    public function store(StoreMaintenanceRequest $request)
    {
        $token = session('access_token');

        try {
            $payload = array_merge($request->validated(), ['status' => 'open']);

            $this->client->post('/api/maintenances', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => $payload
            ]);

            return redirect()->route('mantenimientos.index')
                ->with('success', 'Mantenimiento registrado correctamente.');

        } catch (ClientException $e) {
            return $this->handleApiErrors($e);
        }
    }

    public function show($id)
    {
        $token = session('access_token');

        try {
            $response = $this->client->get("/api/maintenances/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $mantenimiento = $data['data'] ?? [];

            return view('mantenimientos.show', compact('mantenimiento'));
            
        } catch (\Throwable $e) {
            return redirect()->route('mantenimientos.index')->with('error', 'Error al cargar el mantenimiento.');
        }
    }

    public function edit($id)
    {
        $token = session('access_token');

        try {
            $response = $this->client->get("/api/maintenances/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $mantenimiento = $data['data'] ?? [];

            return view('mantenimientos.edit', compact('mantenimiento'));
            
        } catch (\Throwable $e) {
            return redirect()->route('mantenimientos.index')->with('error', 'Error al cargar el mantenimiento para edición.');
        }
    }

    public function update(UpdateMaintenanceRequest $request, $id)
    {
        $token = session('access_token');

        try {
            $this->client->put("/api/maintenances/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => $request->validated()
            ]);

            $msg = $request->status === 'closed'
                ? 'Mantenimiento cerrado. El vehículo quedó disponible.'
                : 'Mantenimiento actualizado correctamente.';

            return redirect()->route('mantenimientos.index')->with('success', $msg);

        } catch (ClientException $e) {
            return $this->handleApiErrors($e);
        }
    }

    public function destroy($id)
    {
        $token = session('access_token');

        try {
            $this->client->delete("/api/maintenances/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento eliminado.');

        } catch (ClientException $e) {
            return $this->handleApiErrors($e);
        }
    }

    private function handleApiErrors(ClientException $e)
    {
        if ($e->getResponse()->getStatusCode() === 422) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            
            if (isset($responseBody['errors'])) {
                return back()->withErrors($responseBody['errors'])->withInput();
            }
            
            if (isset($responseBody['error'])) {
                return back()->withErrors(['api' => $responseBody['error']])->withInput();
            }
        }

        return back()->with('error', 'Error de comunicación con el servidor.')->withInput();
    }
}