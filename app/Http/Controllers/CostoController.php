<?php

namespace App\Http\Controllers;

use App\Models\Costo;
use Illuminate\Http\Request;

class CostoController extends Controller
{
    public function index()
    {
        $data = Costo::all();
        return view('costos.index', compact('data'));
    }

    public function create()
    {
        return view('costos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'monto' => 'required|numeric'
        ]);

        Costo::create($request->all());

        return redirect()->route('costos.index')
            ->with('success', 'Costo registrado correctamente');
    }

    public function destroy($id)
    {
        Costo::findOrFail($id)->delete();

        return redirect()->route('costos.index')
            ->with('success', 'Eliminado correctamente');
    }
}
