<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ReportController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.academy_api.url'),
            'timeout'  => 10,
        ]);
    }

    private function headers()
    {
        return [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . session('access_token'),
        ];
    }

    public function availability(Request $request)
    {
        $vehiculos = [];
        $error     = null;

        if ($request->filled('start') && $request->filled('end')) {
            try {
                $response = $this->client->get('/api/reports/availability', [
                    'headers' => $this->headers(),
                    'query'   => [
                        'start' => $request->start,
                        'end'   => $request->end,
                    ],
                ]);
                $data      = json_decode($response->getBody()->getContents(), true);
                $vehiculos = $data['data'] ?? [];
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $err   = json_decode($e->getResponse()->getBody()->getContents(), true);
                $error = $err['message'] ?? 'Error al obtener el reporte.';
            }
        }

        return view('reports.availability', compact('vehiculos', 'error'));
    }

    public function fleetUsage(Request $request)
    {
        $uso   = [];
        $error = null;

        if ($request->filled('period_start') && $request->filled('period_end')) {
            try {
                $response = $this->client->get('/api/reports/fleet-usage', [
                    'headers' => $this->headers(),
                    'query'   => [
                        'period_start' => $request->period_start,
                        'period_end'   => $request->period_end,
                    ],
                ]);
                $data = json_decode($response->getBody()->getContents(), true);
                $uso  = $data['data'] ?? [];
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $err   = json_decode($e->getResponse()->getBody()->getContents(), true);
                $error = $err['message'] ?? 'Error al obtener el reporte.';
            }
        }

       return view('reports.fleetUsage', compact('uso', 'error'));
    }

    public function driverHistory(Request $request)
    {
        $historial = [];
        $choferes  = [];
        $error     = null;

        try {
            $response = $this->client->get('/api/users', [
                'headers' => $this->headers(),
            ]);
            $data     = json_decode($response->getBody()->getContents(), true);
            $todos    = $data['data']['data'] ?? $data['data'] ?? [];
            $choferes = array_filter($todos, fn($u) => ($u['role_id'] ?? 0) == 3);
        } catch (\Exception $e) {
            $error = 'No se pudo cargar la lista de choferes.';
        }

        if ($request->filled('driver_id')) {
            try {
                $response  = $this->client->get("/api/reports/driver-history/{$request->driver_id}", [
                    'headers' => $this->headers(),
                ]);
                $data      = json_decode($response->getBody()->getContents(), true);
                $historial = $data['data'] ?? [];
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $err   = json_decode($e->getResponse()->getBody()->getContents(), true);
                $error = $err['message'] ?? 'Error al obtener el historial.';
            }
        }

       return view('reports.driverHistory', compact('historial', 'choferes', 'error'));
    }
}