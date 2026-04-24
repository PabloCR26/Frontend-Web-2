<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        
        $client = new \GuzzleHttp\Client([
            'base_uri' => config('services.academy_api.url'),
        ]);

        try {
            $response = $client->get('/api/users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('access_token'),
                    'Accept'        => 'application/json',
                ],
                'query' => array_filter([
                    'status' => $status
                ])
            ]);

            $data = json_decode($response->getBody(), true);

            $users = $data['data']['data'] ?? $data['data'] ?? [];

            return view('users.index', compact('users', 'status'));

        } catch (\Throwable $e) {
            session()->flash('error', 'Error al conectar con la API: ' . $e->getMessage());
            
            return view('users.index', ['users' => [], 'status' => $status]);
        }
    }

    public function create()
    {
        if (!session()->has('access_token')) {
            return redirect()->route('login');
        }
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $token = session('access_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $client = new Client([
            'base_uri' => config('services.academy_api.url'),
        ]);

        try {
            $client->post('/api/users', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => $request->validated(), // Usamos solo los datos validados
            ]);

            return redirect()
                ->route('users.index')
                ->with('success', 'Usuario creado correctamente.');

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 422) {
                $error = json_decode($e->getResponse()->getBody()->getContents(), true);
                return back()->withErrors($error['errors'] ?? [])->withInput();
            }
            return back()->withErrors(['api' => 'Error de conexión con el servidor'])->withInput();
        }
    }

    public function edit($id)
    {
        $token = session('access_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $client = new Client([
            'base_uri' => config('services.academy_api.url'),
        ]);

        try {
            $response = $client->get("/api/users/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $user = data_get($body, 'data', $body);

            return view('users.edit', compact('user'));

        } catch (\Throwable $e) {
            return redirect()->route('users.index')
                ->with('error', 'Error cargando usuario.');
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $token = session('access_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $client = new Client([
            'base_uri' => config('services.academy_api.url'),
        ]);

        try {
            $payload = $request->validated();
            
            if (empty($payload['password'])) {
                unset($payload['password']);
            }

            $client->put("/api/users/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ],
                'json' => $payload,
            ]);

            return redirect()
                ->route('users.index')
                ->with('success', 'Usuario actualizado correctamente.');

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 422) {
                $error = json_decode($e->getResponse()->getBody()->getContents(), true);
                return back()->withErrors($error['errors'] ?? [])->withInput();
            }
            return back()->with('error', 'Error al actualizar usuario.')->withInput();
        }
    }

    public function destroy($id)
    {
        $token = session('access_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $client = new Client([
            'base_uri' => config('services.academy_api.url'),
        ]);

        try {
            $client->delete("/api/users/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ],
            ]);

            return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');

        } catch (ClientException $e) {
            return redirect()->route('users.index')->with('error', 'Error al eliminar usuario.');
        }
    }

    public function restore($id)
    {
        $token = session('access_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $client = new Client([
            'base_uri' => config('services.academy_api.url'),
        ]);

        try {
            $client->patch("/api/users/{$id}/restore", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ],
            ]);

            return redirect()->route('users.index')->with('success', 'Usuario restaurado correctamente.');

        } catch (\Throwable $e) {
            return redirect()->route('users.index')->with('error', 'Error al restaurar usuario.');
        }
    }

    public function deleted()
    {
        $client = new Client([
            'base_uri' => config('services.academy_api.url'),
        ]);

        $response = $client->get('/api/users/deleted', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('access_token'),
                'Accept'        => 'application/json',
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $users = $data['data'] ?? [];

        return view('users.deleted', compact('users'));
    }
}