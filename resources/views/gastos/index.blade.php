@extends('layout')

@section('contenido')

<h2>Gastos</h2>

<a href="{{ route('gastos.create') }}" class="btn btn-primary mb-3">Agregar</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Descripción</th>
            <th>Monto (Bs)</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $c)
        <tr>
            <td>{{ $c->descripcion }}</td>
            <td>{{ number_format($c->monto,2) }}</td>
            <td>
                <form action="{{ route('gastos.destroy', $c->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">X</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
