<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Center;
use App\Models\User;

class Report extends Model
{
    protected $perPage = 20;

    protected $table = 'reports';
    protected $primaryKey = 'reporte_id';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'reportador_id',
        'cantidad_animales',
        'longitud',
        'latitud',
        'direccion',
        'centro_id',
        'aprobado_id',
        'detalle_aprobado',
        'fecha_creacion',
        'fecha_actualizacion',
    ];

    protected $casts = [
        'reportador_id' => 'integer',
        'cantidad_animales' => 'integer',
        'centro_id' => 'integer',
        'longitud' => 'float',
        'latitud' => 'float',
        'fecha_creacion' => 'date',
        'fecha_actualizacion' => 'date',
    ];

    public function center()
    {
        return $this->belongsTo(Center::class, 'centro_id');
    }

    public function reportador()
    {
        return $this->belongsTo(User::class, 'reportador_id');
    }
}
