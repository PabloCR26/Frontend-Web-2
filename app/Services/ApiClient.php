<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url');
    }

    public function get($endpoint)
    {
        return Http::get($this->baseUrl.'/'.$endpoint)->json();
    }

    public function post($endpoint, $data)
    {
        return Http::post($this->baseUrl.'/'.$endpoint, $data)->json();
    }

    public function put($endpoint, $data)
    {
        return Http::put($this->baseUrl.'/'.$endpoint, $data)->json();
    }

    public function delete($endpoint)
    {
        return Http::delete($this->baseUrl.'/'.$endpoint)->json();
    }
}