<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.academy_api.url');
    }

    public function index()
    {
        $response = Http::withToken(session('access_token'))
            ->get($this->baseUrl . '/api/vehicles');

        $data = $response->json();

        $vehiculos = $data['data'] ?? $data;

        if (is_string($vehiculos)) {
            $vehiculos = json_decode($vehiculos, true) ?? [];
        }

        return view('vehiculos.index', [
            'vehiculos' => collect($vehiculos)
        ]);
    }

    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        Http::withToken(session('access_token'))
            ->post($this->baseUrl . '/api/vehicles', $request->all());

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo creado correctamente');
    }

    public function edit($id)
    {
        $response = Http::withToken(session('access_token'))
            ->get($this->baseUrl . "/api/vehicles/{$id}");

        $vehiculo = $response->json();

        return view('vehiculos.edit', [
            'vehiculo' => $vehiculo
        ]);
    }

    public function update(Request $request, $id)
    {
        Http::withToken(session('access_token'))
            ->put($this->baseUrl . "/api/vehicles/{$id}", $request->all());

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado correctamente');
    }

    public function destroy($id)
    {
        Http::withToken(session('access_token'))
            ->delete($this->baseUrl . "/api/vehicles/{$id}");

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente');
    }
}