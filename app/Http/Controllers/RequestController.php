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

        try {
            $response = $this->client->get('/api/vehicle-requests', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $solicitudes = $body['data']['data'] ?? $body['data'] ?? [];

            return view('solicitudes.index', compact('solicitudes'));
        } catch (\Throwable $e) {
            return view('solicitudes.index', ['solicitudes' => []])
                ->with('error', 'No se pudo conectar con el servidor.');
        }
    }

    public function create(Request $request)
    {
        $token = session('access_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $vehiculo = null;
        $choferes = []; 
        $accion = $request->accion; 

        if ($accion === 'asignar') {
            try {
                $resDrivers = $this->client->get("/api/users/drivers", [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                    ]
                ]);
                
                $dataDrivers = json_decode($resDrivers->getBody()->getContents(), true);

                $choferes = $dataDrivers['data'] ?? [];

            } catch (\Throwable $e) {
                $choferes = [];
            }
        }

        if ($request->vehiculo) {
            try {
                $response = $this->client->get("/api/vehicles/{$request->vehiculo}", [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                    ]
                ]);
                $data = json_decode($response->getBody()->getContents(), true);
                $vehiculo = $data['data'] ?? $data;
            } catch (\Throwable $e) { $vehiculo = null; }
        }

        // Se eliminó la carga de $rutas, ya que esto ahora pertenece a ViajeController

        return view('solicitudes.create', compact('vehiculo', 'accion', 'choferes'));
    }

    public function store(Request $request)
    {
        $token = session('access_token');

        $endpoint = ($request->accion === 'asignar') 
            ? '/api/vehicle-requests/direct-assignment' 
            : '/api/vehicle-requests';

        $multipart = [];
        foreach ($request->all() as $key => $val) {
            if ($request->hasFile($key)) {
                $multipart[] = [
                    'name'     => $key,
                    'contents' => fopen($val->path(), 'r'),
                    'filename' => $val->getClientOriginalName()
                ];
            } else {
                if ($key !== 'accion') {
                    $multipart[] = [
                        'name'     => $key,
                        'contents' => $val
                    ];
                }
            }
        }

        try {
            $this->client->post($endpoint, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'multipart' => $multipart
            ]);

            $mensaje = ($request->accion === 'asignar') ? 'Asignación directa creada con éxito' : 'Solicitud creada correctamente';

            return redirect()
                ->route('solicitudes.index')
                ->with('success', $mensaje);

        } catch (ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            $statusCode = $e->getResponse()->getStatusCode();
            
            $errorMsg = $responseBody['error'] ?? $responseBody['message'] ?? 'Error al procesar la solicitud.';
            
            if ($statusCode === 422) {
                $erroresValidacion = $responseBody['errors'] ?? [];

                return redirect()
                    ->back()
                    ->withErrors($erroresValidacion)
                    ->with('error', $errorMsg) 
                    ->withInput();
            }

            return redirect()
                ->back()
                ->with('error', $errorMsg) 
                ->withInput();
        }
    }

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
        } catch (ClientException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $body['error'] ?? 'No se pudo aprobar la solicitud');
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
                'json' => [
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