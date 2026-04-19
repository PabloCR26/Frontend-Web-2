<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

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

        $response = $this->client->get('/api/maintenances', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $mantenimientos = $data['data'] ?? [];

        return view('mantenimientos.index', compact('mantenimientos'));
    }
public function create()
{
    $token = session('access_token');

    $response = $this->client->get('/api/vehicles', [
        'headers' => [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]
    ]);

    $data = json_decode($response->getBody()->getContents(), true);
    $vehiculos = $data['data']['data'] ?? []; // <-- doble ['data']['data']

    return view('mantenimientos.create', compact('vehiculos'));
}
    public function store(Request $request)
    {
        $token = session('access_token');

        try {
            $this->client->post('/api/maintenances', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'vehicle_id'  => $request->vehicle_id,
                    'type'        => $request->type,
                    'start_date'  => $request->start_date,
                    'description' => $request->description,
                    'cost'        => $request->cost,
                    'status'      => 'open',
                ]
            ]);

            return redirect()->route('mantenimientos.index')
                ->with('success', 'Mantenimiento registrado correctamente.');

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->withInput()
                ->with('error', $error['message'] ?? 'Error al registrar el mantenimiento.');
        }
    }

    public function show($id)
    {
        $token = session('access_token');

        $response = $this->client->get("/api/maintenances/$id", [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $mantenimiento = $data['data'] ?? [];

        return view('mantenimientos.show', compact('mantenimiento'));
    }

    public function edit($id)
    {

        $token = session('access_token');
      

        $response = $this->client->get("/api/maintenances/$id", [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $mantenimiento = $data['data'] ?? [];

        return view('mantenimientos.edit', compact('mantenimiento'));
    }

    public function update(Request $request, $id)
    {
        $token = session('access_token');

        try {
            $this->client->put("/api/maintenances/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'type'        => $request->type,
                    'description' => $request->description,
                    'cost'        => $request->cost,
                    'status'      => $request->status,
                    'end_date'    => $request->end_date,
                ]
            ]);

            $msg = $request->status === 'closed'
                ? 'Mantenimiento cerrado. El vehículo quedó disponible.'
                : 'Mantenimiento actualizado correctamente.';

            return redirect()->route('mantenimientos.index')->with('success', $msg);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->withInput()
                ->with('error', $error['message'] ?? 'Error al actualizar.');
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

            return redirect()->route('mantenimientos.index')
                ->with('success', 'Mantenimiento eliminado.');

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $error['message'] ?? 'No se puede eliminar un mantenimiento abierto.');
        }
    }
}