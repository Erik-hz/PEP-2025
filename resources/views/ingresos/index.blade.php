@extends('layout')

@section('contenido')

<h2>Ingresos</h2>

<a href="{{ route('ingresos.create') }}" class="btn btn-primary mb-3">Agregar</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Descripción</th>
            <th>Precio (Bs)</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $i)
        <tr>
            <td>{{ $i->descripcion }}</td>
            <td>{{ number_format($i->precio,2) }}</td>
            <td>
                <form action="{{ route('ingresos.destroy', $i->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">X</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
