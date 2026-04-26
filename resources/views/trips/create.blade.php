@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="mb-4">Registrar salida de vehículo</h3>

    <form action="{{ route('viajes.store') }}" method="POST">
        @csrf

        <!-- Solicitud -->
        <div class="mb-3">
            <label class="form-label fw-bold">Solicitud aprobada</label>
            <select name="vehicle_id" class="form-select" required>

                @foreach($solicitudes as $solicitud)
                    <option value="{{ $solicitud['vehicle_id'] }}">
                        {{ $solicitud['vehicle']['brand'] }} 
                        ({{ $solicitud['user']['name'] }})
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Ruta -->
        <div class="mb-3">
            <label class="form-label fw-bold">Ruta</label>
            <select name="route_id" class="form-select" required>

                @foreach($rutas as $ruta)
                    <option value="{{ $ruta['id'] }}">
                        {{ $ruta['name'] }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- KM salida -->
        <div class="mb-3">
            <label class="form-label fw-bold">Kilometraje salida</label>
            <input type="number" name="km_departure" class="form-control" required>
        </div>

        <button class="btn btn-primary">
            Registrar salida
        </button>
    </form>
</div>

@endsection