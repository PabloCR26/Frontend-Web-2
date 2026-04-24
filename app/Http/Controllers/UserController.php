<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class UserController extends Controller
{

public function index(Request $request)
{
    $status = $request->get('status');

    $client = new \GuzzleHttp\Client([
        'base_uri' => config('services.academy_api.url'),
    ]);

    if ($status === 'deleted') {

        $response = $client->get('/api/users/deleted', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('access_token'),
                'Accept' => 'application/json',
            ]
        ]);

    } else {

        $response = $client->get('/api/users', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('access_token'),
                'Accept' => 'application/json',
            ]
        ]);
    }

    $data = json_decode($response->getBody(), true);

    $users = $data['data']['data'] ?? $data['data'] ?? [];

    return view('users.index', compact('users', 'status'));
}

public function create()
{
    if (!session()->has('access_token')) {
        return redirect()->route('login');
    }

    return view('users.create');
}

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'telephone' => 'required|string|max:30',
        'role_id' => 'required|integer',
        'password' => 'required|min:6',
    ]);

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
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'role_id' => $request->role_id,
                'password' => $request->password,
            ],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente.');

    } catch (RequestException $e) {

        $response = $e->getResponse();

        if ($response) {
            $error = json_decode($response->getBody()->getContents(), true);

            return back()
                ->withErrors($error['errors'] ?? ['api' => $error['message'] ?? 'Error desconocido'])
                ->withInput();
        }

        return back()
            ->withErrors(['api' => 'Error de conexión con el servidor'])
            ->withInput();
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
                    'Accept' => 'application/json',
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


   public function update(Request $request, $id)
{
    $token = session('access_token');

    if (!$token) {
        return redirect()->route('login');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'telephone' => 'required|string|max:30',
        'role_id' => 'required|integer',
        'password' => 'nullable|min:6',
    ]);

    $client = new Client([
        'base_uri' => config('services.academy_api.url'),
    ]);

    try {

        $payload = [
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $payload['password'] = $request->password;
        }

        $client->put("/api/users/{$id}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');

    } catch (\Throwable $e) {

        return back()
            ->with('error', 'Error al actualizar usuario.')
            ->withInput();
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
                    'Accept' => 'application/json',
                ],
            ]);

            return redirect()
                ->route('users.index')
                ->with('success', 'Usuario eliminado correctamente.');

        } catch (RequestException $e) {

            return redirect()
                ->route('users.index')
                ->with('error', 'Error al eliminar usuario.');
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
                    'Accept' => 'application/json',
                ],
            ]);

            return redirect()
                ->route('users.index')
                ->with('success', 'Usuario restaurado correctamente.');

        } catch (\Throwable $e) {

            return redirect()
                ->route('users.index')
                ->with('error', 'Error al restaurar usuario.');
        }
    }
    public function deleted()
{
    $client = new \GuzzleHttp\Client([
        'base_uri' => config('services.academy_api.url'),
    ]);

        $response = $client->get('/api/users/deleted', [
        'headers' => [
            'Authorization' => 'Bearer ' . session('access_token'),
            'Accept' => 'application/json',
        ]
    ]);

    $data = json_decode($response->getBody(), true);

    $users = $data['data'] ?? [];

    return view('users.deleted', compact('users'));
}
}