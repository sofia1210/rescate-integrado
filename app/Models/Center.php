<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Center
 *
 * @property $id
 * @property $nombre
 * @property $telefono
 * @property $longitud
 * @property $latitud
 * @property $direccion
 * @property $capacidad_maxima
 * @property $fecha_creacion
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Center extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'telefono', 'longitud', 'latitud', 'direccion', 'capacidad_maxima', 'fecha_creacion'];


}
