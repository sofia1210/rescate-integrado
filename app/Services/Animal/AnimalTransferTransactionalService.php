<?php

namespace App\Services\Animal;

use App\Models\AnimalFile;
use App\Models\AnimalHistory;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;

class AnimalTransferTransactionalService
{
	public function create(array $data): Transfer
	{
		return DB::transaction(function () use ($data) {
			$transfer = Transfer::create($data);

			// Registrar historial si viene animal_id (no es primer traslado)
			if (!empty($data['animal_id'])) {
				$animalFile = AnimalFile::where('animal_id', $data['animal_id'])
					->orderByDesc('id')
					->first();
				if ($animalFile) {
					AnimalHistory::create([
						'animal_file_id' => $animalFile->id,
						'valores_antiguos' => null,
						'valores_nuevos' => [
							'transfer' => [
								'id' => $transfer->id,
								'persona_id' => $transfer->persona_id,
								'centro_id' => $transfer->centro_id,
								'observaciones' => $transfer->observaciones,
								'primer_traslado' => (bool)($data['primer_traslado'] ?? false),
							],
						],
						'observaciones' => [
							'texto' => 'Registro de traslado',
						],
					]);
				}
			}

			return $transfer;
		});
	}
}




