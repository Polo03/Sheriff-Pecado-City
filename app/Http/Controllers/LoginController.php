<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        // Si ya está logueado, ir directamente al menú principal
        if ($request->session()->has('usuario_id')) {
            return redirect()->route('fichaje.index');
        }

        // Comprobar si existe una cookie de "recordarme"
        $usuarioId = $request->cookie('usuario_recordado');

        if ($usuarioId) {

            $usuario = DB::table('agentes')
                ->where('id', $usuarioId)
                ->first();

            if ($usuario) {

                $request->session()->put('usuario_id', $usuario->id);
                $request->session()->put('usuario', $usuario->usuario);
                $request->session()->put('nombre', $usuario->nombre);

                return redirect()->route('fichaje.index');
            }
        }

        return view('login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'contraseña' => 'required',
        ]);


        $usuario = DB::table('agentes')
            ->where('usuario', $request->usuario)
            ->where('contraseña', $request->contraseña)
            ->first();


        if (!$usuario) {

            return back()
                ->withErrors([
                    'usuario' => 'Usuario o contraseña incorrectos.',
                ])
                ->withInput();
        }


        // Regenerar sesión
        $request->session()->regenerate();


        // Guardar datos del usuario
        $request->session()->put('usuario_id', $usuario->id);

        $request->session()->put('usuario', $usuario->usuario);

        $request->session()->put('nombre', $usuario->nombre);


        // =========================
        // RECORDAR USUARIO
        // =========================

        if ($request->has('recordar')) {

            Cookie::queue(
                Cookie::make(
                    'usuario_recordado',
                    $usuario->id,
                    60 * 24 * 30
                )
            );

        } else {

            Cookie::queue(
                Cookie::forget('usuario_recordado')
            );

        }


        return redirect()->route('fichaje.index');
    }


    public function logout(Request $request)
    {
        // Eliminar sesión
        $request->session()->flush();


        // Eliminar cookie de recordar
        Cookie::queue(
            Cookie::forget('usuario_recordado')
        );


        return redirect()->route('login');
    }
}