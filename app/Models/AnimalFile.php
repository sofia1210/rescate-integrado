<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AnimalFile
 *
 * @property $id
 * @property $nombre
 * @property $sexo
 * @property $tipo_id
 * @property $reporte_id
 * @property $especie_id
 * @property $imagen_url
 * @property $raza_id
 * @property $estado_id
 * @property $adopcion_id
 * @property $liberacion_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Adoption $adoption
 * @property Species $species
 * @property AnimalStatus $animalStatus
 * @property Release $release
 * @property Report $report
 * @property AnimalType $animalType
 * @property Care[] $cares
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AnimalFile extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'sexo', 'tipo_id', 'reporte_id', 'especie_id', 'imagen_url', 'raza_id', 'estado_id', 'adopcion_id', 'liberacion_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adoption()
    {
        return $this->belongsTo(\App\Models\Adoption::class, 'adopcion_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function species()
    {
        return $this->belongsTo(\App\Models\Species::class, 'especie_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function animalStatus()
    {
        return $this->belongsTo(\App\Models\AnimalStatus::class, 'estado_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function release()
    {
        return $this->belongsTo(\App\Models\Release::class, 'liberacion_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report()
    {
        return $this->belongsTo(\App\Models\Report::class, 'reporte_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function animalType()
    {
        return $this->belongsTo(\App\Models\AnimalType::class, 'tipo_id', 'id');
    }
    
    /**
     * Raza relacionada vía raza_id
     */
    public function breed()
    {
        return $this->belongsTo(\App\Models\Breed::class, 'raza_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cares()
    {
        return $this->hasMany(\App\Models\Care::class, 'hoja_animal_id', 'id');
    }
    
}
