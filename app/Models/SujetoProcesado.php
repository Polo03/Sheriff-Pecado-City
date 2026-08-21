<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SujetoProcesado extends Model
{
    protected $table = 'sujetos_procesados';

    protected $fillable = [
        'nombre',
        'dni',
        'foto_sujeto_procesado',
        'foto_dni',
        'foto_antecedentes',
    ];
}