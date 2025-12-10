@extends('layout')

@section('contenido')

<h2>Nuevo Costo</h2>

<form action="{{ route('costos.store') }}" method="POST">
    @csrf

    <label>Descripción</label>
    <input type="text" name="descripcion" class="form-control mb-3" required>

    <label>Monto (Bs)</label>
    <input type="number" step="0.01" name="monto" class="form-control mb-3" required>

    <button class="btn btn-primary">Guardar</button>
</form>

@endsection
