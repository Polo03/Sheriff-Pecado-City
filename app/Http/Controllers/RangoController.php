<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RangoController extends Controller
{
    public function index()
    {
        return view('rangos');
    }

    public function select()
    {
        $rangos = DB::table('rangos')->get();

        return view('rangos', compact('rangos'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'rango' => 'required|string|max:255',
            'sueldo_base' => 'required|numeric',
            'sueldo_hora_extra' => 'required|numeric',
        ]);

        DB::table('rangos')->insert([
            'rango' => $request->rango,
            'sueldo base' => $request->sueldo_base,
            'sueldo_hora_extra' => $request->sueldo_hora_extra,
        ]);

        return redirect('/rangos')->with('mensaje', 'Rango insertado correctamente.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'rango' => 'required|string|max:255',
            'sueldo_base' => 'required|numeric',
            'sueldo_hora_extra' => 'required|numeric',
        ]);

        DB::table('rangos')
            ->where('id', $request->id)
            ->update([
                'rango' => $request->rango,
                'sueldo base' => $request->sueldo_base,
                'sueldo_hora_extra' => $request->sueldo_hora_extra,
            ]);

        return redirect('/rangos')->with('mensaje', 'Rango actualizado correctamente.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        DB::table('rangos')
            ->where('id', $request->id)
            ->delete();

        return redirect('/rangos')->with('mensaje', 'Rango eliminado correctamente.');
    }
}