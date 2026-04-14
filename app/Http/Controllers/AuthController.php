<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $client = new Client([
            'base_uri' => config('services.academy_api.url'),
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/login', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            session([
                'access_token' => $data['access_token'],
                'auth_user' => $data['user'],
            ]);

            return redirect()->route('dashboard');

        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($response) {
                $data = json_decode($response->getBody()->getContents(), true);

                return back()->withErrors([
                    'email' => $data['message'] ?? 'No fue posible iniciar sesión.',
                ])->onlyInput('email');
            }

            return back()->withErrors([
                'email' => 'No fue posible conectar con el backend.',
            ])->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        $token = session('access_token');

        if ($token) {
            $client = new Client([
                'base_uri' => config('services.academy_api.url'),
                'timeout'  => 10,
            ]);

            try {
                $client->post('/api/logout', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                    ],
                ]);
            } catch (\Throwable $e) {
            }
        }

        $request->session()->forget(['access_token', 'auth_user']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    
}