<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VehicleController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.academy_api.url'),
            'timeout'  => 10,
        ]);
    }

    // LISTAR
    public function index()
    {
        $token = session('access_token');

        $response = $this->client->get('/api/vehicles', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        $vehiculos = $body['data']['data'] ?? [];

        return view('vehiculos.index', compact('vehiculos'));
    }

    // FORM CREATE
    public function create()
    {
        return view('vehiculos.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        $token = session('access_token');

        $this->client->post('/api/vehicles', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => $request->all()
        ]);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehiculo creado correctamente');
    }

    // SHOW
    public function show($id)
    {
        $token = session('access_token');

        $response = $this->client->get("/api/vehicles/$id", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $vehiculo = json_decode($response->getBody()->getContents(), true);

        return view('vehiculos.show', compact('vehiculo'));
    }

    // EDIT
    public function edit($id)
    {
        $token = session('access_token');

        $response = $this->client->get("/api/vehicles/$id", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $vehiculo = json_decode($response->getBody()->getContents(), true);

        return view('vehiculos.edit', compact('vehiculo'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $token = session('access_token');

        $this->client->put("/api/vehicles/$id", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => $request->all()
        ]);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehiculo actualizado');
    }

    // DELETE
    public function destroy($id)
    {
        $token = session('access_token');

        $this->client->delete("/api/vehicles/$id", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehiculo eliminado');
    }
}
