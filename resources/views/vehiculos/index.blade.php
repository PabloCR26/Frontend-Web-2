@foreach($vehiculos as $vehiculo)
<tr>
    <td>{{ $vehiculo['id'] }}</td>
    <td>{{ $vehiculo['modelo'] }}</td>
    <td>{{ $vehiculo['marca'] }}</td>
    <td>{{ $vehiculo['estado'] }}</td>
</tr>
@endforeach