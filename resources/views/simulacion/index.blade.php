@extends('layout')

@section('contenido')

<h2 class="mb-4">Realizar nuevos calculos</h2>

<form action="{{ route('simulacion.store') }}" method="POST">
    @csrf

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Periodo</label>
            <select name="periodo_nombre" class="form-select" required>
                <option value="dia"  {{ old('periodo_nombre')=='dia' ? 'selected' : '' }}>Día</option>
                <option value="mes"  {{ old('periodo_nombre')=='mes' ? 'selected' : '' }}>Mes</option>
                <option value="año"  {{ old('periodo_nombre')=='año' ? 'selected' : '' }}>Año</option>
            </select>
        </div>

        <div class="col">
            <label class="form-label">Venta inicial (Inversión)</label>
            <input type="number" class="form-control"
                   name="venta_inicial"
                   step="0.01"
                   value="{{ old('venta_inicial') }}"
                   required>
        </div>

        <div class="col">
            <label class="form-label">Tasa de descuento (%)</label>
            <input type="number" class="form-control"
                   name="tasa_descuento"
                   step="0.01"
                   value="{{ old('tasa_descuento') }}"
                   required>
        </div>
    </div>

    <hr>

    <h5>Ingresar periodos y número de ventas</h5>

    @for ($i = 1; $i <= 5; $i++)
        <div class="row mb-2">
            <div class="col-2">
                <label class="form-label">Periodo {{ $i }}</label>
            </div>

            <div class="col">
                <input type="number"
                       step="0.01"
                       name="periodo[{{ $i }}]"
                       class="form-control"
                       placeholder="Nro ventas"
                       value="{{ old('periodo.' . $i) }}">
            </div>
        </div>
    @endfor

    <button class="btn btn-primary mt-3">Calcular</button>
</form>

@endsection
