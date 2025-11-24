<?php

namespace App\Services\Animal;

use App\Models\Adoption;
use App\Models\AnimalFile;
use App\Models\AnimalHistory;
use Illuminate\Support\Facades\DB;

class AnimalAdoptionTransactionalService
{
	/**
	 * Estados de salud permitidos para adoptar.
	 */
	private array $allowedStatuses = ['estable','bueno','muy bueno','excelente'];

	public function create(array $data): Adoption
	{
		return DB::transaction(function () use ($data) {
			$animalFile = AnimalFile::with('animalStatus','animal')->findOrFail($data['animal_file_id']);

			$statusName = mb_strtolower((string)($animalFile->animalStatus->nombre ?? ''));
			if (!in_array($statusName, $this->allowedStatuses, true)) {
				throw new \DomainException('El animal no está en un estado de salud apto para adopción.');
			}

			$adoption = Adoption::create($data);

			AnimalHistory::create([
				'animal_file_id' => $animalFile->id,
				'valores_antiguos' => null,
				'valores_nuevos' => [
					'adopcion' => [
						'id' => $adoption->id,
						'aprobada' => (bool)$adoption->aprobada,
						'adoptante_id' => $adoption->adoptante_id,
						'direccion' => $adoption->direccion,
						'latitud' => $adoption->latitud,
						'longitud' => $adoption->longitud,
					],
				],
				'observaciones' => [
					'texto' => 'Registro de adopción',
				],
			]);

			return $adoption;
		});
	}
}




