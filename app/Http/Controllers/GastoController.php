<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function index()
    {
        $data = Gasto::all();
        return view('gastos.index', compact('data'));
    }

    public function create()
    {
        return view('gastos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'monto' => 'required|numeric'
        ]);

        Gasto::create($request->all());

        return redirect()->route('gastos.index')
            ->with('success', 'Gasto registrado correctamente');
    }

    public function destroy($id)
    {
        Gasto::findOrFail($id)->delete();

        return redirect()->route('gastos.index')
            ->with('success', 'Eliminado correctamente');
    }
}
