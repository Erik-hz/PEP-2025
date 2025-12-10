<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index()
    {
        $data = Ingreso::all();
        return view('ingresos.index', compact('data'));
    }

    public function create()
    {
        return view('ingresos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'precio' => 'required|numeric'
        ]);

        Ingreso::create($request->all());

        return redirect()->route('ingresos.index')
            ->with('success', 'Ingreso registrado correctamente');
    }

    public function destroy($id)
    {
        Ingreso::find($id)->delete();

        return redirect()->route('ingresos.index')
            ->with('success', 'Eliminado correctamente');
    }
}
