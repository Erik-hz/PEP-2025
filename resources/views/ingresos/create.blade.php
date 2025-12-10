@extends('layout')

@section('contenido')

<h2>Nuevo Ingreso</h2>

<form action="{{ route('ingresos.store') }}" method="POST">
    @csrf

    <label>Descripción</label>
    <input type="text" name="descripcion" class="form-control mb-3" required>

    <label>Precio (Bs)</label>
    <input type="number" step="0.01" name="precio" class="form-control mb-3" required>

    <button class="btn btn-primary">Guardar</button>
</form>

@endsection
