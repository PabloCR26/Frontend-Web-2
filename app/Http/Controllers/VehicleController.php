<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;

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
    public function index(Request $request)
    {
        $token = session('access_token');
        $status = $request->query('status');
        $start_datetime = $request->query('start_datetime');
        $end_datetime = $request->query('end_datetime');

        try {
            if (!empty($start_datetime) && !empty($end_datetime)) {
                
                $response = $this->client->post('/api/vehicle-requests/availability', [
                    'headers' => [
                        'Accept'        => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                    ],
                    'json' => [
                        'start_datetime' => \Carbon\Carbon::parse($start_datetime)->format('Y-m-d H:i:s'),
                        'end_datetime'   => \Carbon\Carbon::parse($end_datetime)->format('Y-m-d H:i:s'),
                    ]
                ]);

            } 
            else {
                $response = $this->client->get('/api/vehicles', [
                    'headers' => [
                        'Accept'        => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                    ],
                    'query' => array_filter(['status' => $status])
                ]);
            }

            $body = json_decode($response->getBody()->getContents(), true);
            $vehiculos = $body['data']['data'] ?? $body['data'] ?? [];

            return view('vehiculos.index', compact('vehiculos', 'status', 'start_datetime', 'end_datetime'));

        } catch (\Throwable $e) {
            session()->flash('error', 'Error al cargar los vehículos desde la base de datos.');
            return view('vehiculos.index', [
                'vehiculos' => [], 
                'status' => $status, 
                'start_datetime' => $start_datetime, 
                'end_datetime' => $end_datetime
            ]);
        }
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
            $this->client->post('/api/vehicles', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'multipart' => $multipart
            ]);

            return redirect()->route('vehiculos.index')->with('success', 'Vehículo guardado');

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 422) {
                $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
                $erroresApi = $responseBody['errors'] ?? [];

                return redirect()->back()->withErrors($erroresApi)->withInput();
            }

            throw $e;
        }
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
    public function update(UpdateVehicleRequest $request, $id)
    {
        $token = session('access_token');
        $multipart = [];

        foreach ($request->validated() as $key => $value) {
            if ($key !== 'image') {
                $multipart[] = ['name' => $key, 'contents' => $value];
            }
        }

        if ($request->hasFile('image')) {
            $multipart[] = [
                'name'     => 'image',
                'contents' => fopen($request->file('image')->path(), 'r'),
                'filename' => $request->file('image')->getClientOriginalName()
            ];
        }

        $multipart[] = ['name' => '_method', 'contents' => 'PUT'];

        try {
            $this->client->post("/api/vehicles/$id", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'multipart' => $multipart
            ]);

            return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado con éxito');

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 422) {
                $errors = json_decode($e->getResponse()->getBody()->getContents(), true)['errors'];
                return redirect()->back()->withErrors($errors)->withInput();
            }
            throw $e;
        }
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
