@extends('layout')

@section('contenido')

<h2 class="mb-4">Resultados de los calculos</h2>

{{-- BOTÓN IMPRIMIR --}}
<div class="mb-3">
    <button onclick="window.print()" class="btn btn-primary">
        🖨 Imprimir Resultados
    {{-- CONTENIDO QUE SOLO SE VE AL IMPRIMIR --}}
    <style>
    @media print {
        .solo-impresion {
            display: block !important;
        }
        .no-imprimir {
            display: none !important;
        }
    }
    </style>

    <div class="solo-impresion d-none mt-4">

        <h3>Gastos del Proyecto</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Descripción</th>
                    <th>Monto (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gastos as $g)
                <tr>
                    <td>{{ $g->descripcion }}</td>
                    <td>{{ number_format($g->monto,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Costos del Proyecto</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Descripción</th>
                    <th>Monto (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($costos as $c)
                <tr>
                    <td>{{ $c->descripcion }}</td>
                    <td>{{ number_format($c->monto,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Ingresos</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Descripción</th>
                    <th>Precio (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $i)
                <tr>
                    <td>{{ $i->descripcion }}</td>
                    <td>{{ number_format($i->precio,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    </button>
</div>

<div class="card mb-4">
    <div class="card-body">
        <strong>Periodo:</strong> {{ ucfirst($sim->periodo_nombre) }} <br>
        <strong>Precio de venta:</strong> Bs {{ number_format($sim->venta_inicial,2) }} <br>
        <strong>Tasa de descuento:</strong> {{ $sim->tasa_descuento }} %
    </div>
</div>

{{-- LISTA RESUMIDA DE INGRESOS, COSTOS, GASTOS --}}
<div class="card mb-4">
    <div class="card-header bg-dark text-white">Resumen Económico</div>
    <div class="card-body">

        @php
            $totalIngresos = array_sum(array_column($tabla, 'ingreso'));
            $totalCostosVar = array_sum(array_column($tabla, 'cv'));
            $totalGastosFijos = array_sum(array_column($tabla, 'fg'));
            $totalCostos = $totalCostosVar + $totalGastosFijos;
        @endphp

        <ul class="list-group">
            <li class="list-group-item">
                <strong>Total Ingresos:</strong> Bs {{ number_format($totalIngresos,2) }}
            </li>
            <li class="list-group-item">
                <strong>Total Costos Variables:</strong> Bs {{ number_format($totalCostosVar,2) }}
            </li>
            <li class="list-group-item">
                <strong>Total Gastos Fijos:</strong> Bs {{ number_format($totalGastosFijos,2) }}
            </li>
            <li class="list-group-item">
                <strong>Inversión Inicial:</strong> Bs {{ number_format($inv,2) }}
            </li>
        </ul>

    </div>
</div>

{{-- TABLA COMPLETA --}}
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>{{ strtoupper($sim->periodo_nombre) }}</th>
            <th>Nro de ventas</th>
            <th>Ingresos (Bs)</th>
            <th>Costos Variables (Bs)</th>
            <th>Gastos Fijos (Bs)</th>
            <th>Flujo Neto (Bs)</th>
            <th>FN Acum. (Bs)</th>
            <th>VAN (Bs)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tabla as $row)
        <tr>
            <td>{{ $row['periodo'] }}</td>
            <td>{{ number_format($row['ventas'],2) }}</td>
            <td>{{ number_format($row['ingreso'],2) }}</td>
            <td>{{ number_format($row['cv'],2) }}</td>
            <td>{{ number_format($row['fg'],2) }}</td>
            <td>{{ number_format($row['flujo'],2) }}</td>
            <td>{{ number_format($row['acumulado'],2) }}</td>
            <td>{{ number_format($row['van'],4) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- INDICADORES --}}
<div class="mt-4">
    <h4>Indicadores Económicos</h4>

    @php
        $bc = $sumflujo / $inv;
        $ir = $vanTotal / $inv;
    @endphp

    <ul class="list-group">
        <li class="list-group-item">
            <strong>VAN:</strong> Bs {{ number_format($vanTotal, 2) }}
        </li>
        <li class="list-group-item">
            <strong>TIR:</strong> {{ number_format($tir,2) }} %
        </li>
        <li class="list-group-item">
            <strong>B/C:</strong> {{ number_format($bc,2) }}
        </li>
        <li class="list-group-item">
            <strong>IR:</strong> {{ number_format($ir,2) }}
        </li>
        <li class="list-group-item">
            <strong>PRI:</strong> {{ number_format($pri,2) }}
        </li>
    </ul>
</div>

@endsection
