<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PlantillaController extends Controller
{
    public function index()
    {
        $agentes = DB::table('agentes')
            ->join('rangos', 'rangos.rango', '=', 'agentes.rango')
            ->select(
                'agentes.id',
                'agentes.nombre',
                'agentes.placa',
                'agentes.rango',
                'rangos.escala'
            )
            ->orderBy('rangos.id')
            ->orderBy('agentes.nombre')
            ->get();

        $plantilla = $agentes->groupBy('rango');

        return view('plantilla', compact('plantilla'));
    }
}