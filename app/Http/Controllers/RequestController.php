<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
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

        $response = $this->client->get('/api/vehicle-requests', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        $solicitudes = $body['data']['data'] ?? [];

        return view('solicitudes.index', compact('solicitudes'));
    }


    public function create(Request $request)
    {
        $token = session('access_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $vehiculo = null;
        $rutas = [];
        $accion = $request->accion;

        if ($request->vehiculo) {
            $response = $this->client->get("/api/vehicles/{$request->vehiculo}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $vehiculo = $data['data'] ?? $data;
        }

        $responseRutas = $this->client->get("/api/routes", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        $dataRutas = json_decode($responseRutas->getBody()->getContents(), true);

        $rutas = $dataRutas['data']['data'] ?? [];


        return view('solicitudes.create', compact('vehiculo', 'accion', 'rutas'));
    }


    public function store(Request $request)
    {
        $token = session('access_token');

        $multipart = [];

        foreach ($request->all() as $key => $val) {
            if ($request->hasFile($key)) {
                $multipart[] = [
                    'name'     => $key,
                    'contents' => fopen($val->path(), 'r'),
                    'filename' => $val->getClientOriginalName()
                ];
            } else {
                $multipart[] = [
                    'name'     => $key,
                    'contents' => $val
                ];
            }
        }

        try {
            $this->client->post('/api/vehicle-requests', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'multipart' => $multipart
            ]);

            return redirect()
                ->route('vehiculos.index')
                ->with('success', 'Solicitud creada correctamente');
        } catch (ClientException $e) {

            if ($e->getResponse()->getStatusCode() === 422) {

                $responseBody = json_decode(
                    $e->getResponse()->getBody()->getContents(),
                    true
                );

                $erroresApi = $responseBody['errors'] ?? [];

                return redirect()
                    ->back()
                    ->withErrors($erroresApi)
                    ->withInput();
            }

            throw $e;
        }
    }

    public function show() {}

    public function approve($id)
    {
        $token = session('access_token');

        try {
            $this->client->patch("/api/vehicle-requests/{$id}/approve", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ]
            ]);

            return back()->with('success', 'Solicitud aprobada');
        } catch (\Throwable $e) {
            return back()->with('error', 'No se pudo aprobar la solicitud');
        }
    }

    public function reject(Request $request, $id)
    {
        $token = session('access_token');

        try {
            $this->client->patch("/api/vehicle-requests/{$id}/reject", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'observation' => $request->observation
                ]
            ]);

            return back()->with('success', 'Solicitud rechazada');
        } catch (\Throwable $e) {
            return back()->with('error', 'No se pudo rechazar la solicitud');
        }
    }

    public function cancel($id)
    {
        $token = session('access_token');

        try {
            $this->client->patch("/api/vehicle-requests/{$id}/cancel", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ]
            ]);

            return back()->with('success', 'Solicitud cancelada');
        } catch (\Throwable $e) {
            return back()->with('error', 'No se pudo cancelar la solicitud');
        }
    }
}
