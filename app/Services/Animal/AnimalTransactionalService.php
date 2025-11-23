<?php

namespace App\Services\Animal;

use App\Models\Animal;
use App\Models\AnimalFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnimalTransactionalService
{
	/**
	 * Crea un Animal y su Hoja de Animal (AnimalFile) en una transacción.
	 *
	 * @param array $animalData Campos para App\Models\Animal
	 * @param array $animalFileData Campos para App\Models\AnimalFile (sin animal_id ni imagen_url)
	 * @param UploadedFile|null $image Archivo de imagen opcional
	 * @return array{animal: Animal, animalFile: AnimalFile}
	 */
	public function createWithFile(array $animalData, array $animalFileData, ?UploadedFile $image = null): array
	{
		DB::beginTransaction();

		$storedPath = null;
		try {
			$animal = Animal::create($animalData);

			if ($image) {
				$storedPath = $image->store('animal_files', 'public');
				$animalFileData['imagen_url'] = $storedPath;
			}

			$animalFileData['animal_id'] = $animal->id;
			$animalFile = AnimalFile::create($animalFileData);

			DB::commit();

			return [
				'animal' => $animal,
				'animalFile' => $animalFile,
			];
		} catch (\Throwable $e) {
			DB::rollBack();
			if ($storedPath) {
				Storage::disk('public')->delete($storedPath);
			}
			throw $e;
		}
	}
}


