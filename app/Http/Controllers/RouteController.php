<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;

class RouteController extends Controller
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
            $response = $this->client->get('/api/routes', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            $rutas = $data['data']['data'] ?? $data['data'] ?? [];

            return view('rutas.index', compact('rutas'));
            
        } catch (\Throwable $e) {
            session()->flash('error', 'Error al conectar con la API de rutas.');
            return view('rutas.index', ['rutas' => []]);
        }
    }

    public function create()
    {
        return view('rutas.create');
    }

    public function store(StoreRouteRequest $request)
    {
        $token = session('access_token');

        try {
            $this->client->post('/api/routes', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => $request->validated()
            ]);

            return redirect()->route('rutas.index')
                ->with('success', 'Ruta registrada correctamente.');

        } catch (ClientException $e) {
            return $this->handleApiErrors($e);
        }
    }

    public function show($id)
    {
        $token = session('access_token');

        try {
            $response = $this->client->get("/api/routes/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $ruta = $data['data'] ?? [];

            return view('rutas.show', compact('ruta'));
            
        } catch (\Throwable $e) {
            return redirect()->route('rutas.index')->with('error', 'Error al cargar la ruta.');
        }
    }

    public function edit($id)
    {
        $token = session('access_token');

        try {
            $response = $this->client->get("/api/routes/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $ruta = $data['data'] ?? [];

            return view('rutas.edit', compact('ruta'));
            
        } catch (\Throwable $e) {
            return redirect()->route('rutas.index')->with('error', 'Error al cargar la ruta para edición.');
        }
    }

    public function update(UpdateRouteRequest $request, $id)
    {
        $token = session('access_token');

        try {
            $this->client->put("/api/routes/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => $request->validated()
            ]);

            return redirect()->route('rutas.index')->with('success', 'Ruta actualizada correctamente.');

        } catch (ClientException $e) {
            return $this->handleApiErrors($e);
        }
    }

    public function destroy($id)
    {
        $token = session('access_token');

        try {
            $this->client->delete("/api/routes/$id", [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            return redirect()->route('rutas.index')->with('success', 'Ruta eliminada.');

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