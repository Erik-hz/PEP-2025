<?php

namespace App\Http\Controllers;

use App\Models\Costo;
use App\Models\Gasto;
use App\Models\Ingreso;
use App\Models\Simulacion;
use App\Models\SimulacionPeriodo;
use Illuminate\Http\Request;

class SimulacionController extends Controller
{
    public function index()
    {
        return view('simulacion.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'periodo_nombre' => 'required',
            'venta_inicial' => 'required|numeric',
            'tasa_descuento' => 'required|numeric'
        ]);

        $sim = Simulacion::create([
            'periodo_nombre' => $request->periodo_nombre,
            'venta_inicial' => $request->venta_inicial,
            'tasa_descuento' => $request->tasa_descuento
        ]);

        // Guardar los periodos (número de ventas por día/mes/año)
        foreach ($request->periodo as $i => $numVentas) {
            if ($numVentas !== null) {
                SimulacionPeriodo::create([
                    'simulacion_id' => $sim->id,
                    'periodo' => $i,
                    'nro_ventas' => $numVentas
                ]);
            }
        }

        return redirect()->route('simulacion.resultado', $sim->id);
    }

    public function resultado($id)
    {
        $sim = Simulacion::findOrFail($id);
        $periodos = $sim->periodos()->orderBy('periodo')->get();
        $costos = Costo::all();
        $gastos = Gasto::all();
        $ingresos = Ingreso::all();
        // Costos variables y gastos fijos
        $costosVariables = Costo::sum('monto');
        $gastosFijos = Gasto::sum('monto');

        // Precio unitario de ingreso
        $precioVenta = $sim->venta_inicial;

        $tasa = $sim->tasa_descuento / 100;

        $tabla = [];
        $acum = -Ingreso::sum('precio');
        $vanTotal = -Ingreso::sum('precio');
        $inv = Ingreso::sum('precio');
        $flujos = [];

        foreach ($periodos as $p) {

            $ing = $p->nro_ventas * $precioVenta;
            $cv = $p->nro_ventas * $costosVariables;
            $fg = $gastosFijos;

            $flujoNeto = $ing - $cv - $fg;
            $acum += $flujoNeto;

            // VAN por periodo
            $van = $flujoNeto / pow(1 + $tasa, $p->periodo);
            $vanTotal += $van;

            $tabla[] = [
                'periodo' => $p->periodo,
                'ventas' => $p->nro_ventas,
                'ingreso' => $ing,
                'cv' => $cv,
                'fg' => $fg,
                'flujo' => $flujoNeto,
                'acumulado' => $acum,
                'van' => $van
            ];

            $flujos[] = $flujoNeto;
        }
        $sumflujo = $acum + $inv;
        // Calcular TIR
        $tir = $this->calcularTIR([- Ingreso::sum('precio'), ...$flujos]) * 100;
        $pri = $this->calcularPRI($tabla, $inv);

        return view('simulacion.resultado', compact(
            'sim', 'tabla', 'vanTotal', 'tir', 'sumflujo', 'inv', 'pri', 'gastos','costos', 'ingresos'
        ));
    }

    // Método Newton-Raphson para TIR
    private function calcularTIR($flujos)
    {
        $tasa = 0.1; 
        for ($i = 0; $i < 100; $i++) {

            $f = 0;
            $fd = 0;

            foreach ($flujos as $n => $v) {
                $f += $v / pow(1 + $tasa, $n);
                $fd -= $n * $v / pow(1 + $tasa, $n + 1);
            }

            $nuevaTasa = $tasa - ($f / $fd);
            if (abs($nuevaTasa - $tasa) < 0.00001) break;

            $tasa = $nuevaTasa;
        }

        return $tasa;
    }
    private function calcularPRI($tabla, $inv)
    {
        $sumaFlujosPrevios = 0;

        $total = count($tabla);

        foreach ($tabla as $i => $fila) {

            $dias = $fila['periodo'];       // L5, M5, N5 ...
            $flujo = $fila['flujo'];        // L10, M10 ...
            $acumulado = $fila['acumulado']; // L11, M11 ...
            $sumaFlujosPrevios += $flujo;
            // Cuando Excel encuentra el primer ACUMULADO > 0
            if ($acumulado > 0) {

                // Si es el último periodo (P en Excel)

                // Si no es el último, aplica la fórmula generalizada:
                // PRI = días + ( (inv - suma_flujo_previos) / flujo_actual )
                return $dias + (($inv - $sumaFlujosPrevios) / $flujo);
            }

            // Suma de flujos previos (SUMA(L10:M10:N10...))
            
        }

        // Si nunca se recupera, devolver último día
        return $tabla[$total - 1]['periodo'];
    }

}
