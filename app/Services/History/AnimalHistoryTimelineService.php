<?php

namespace App\Services\History;

use App\Models\AnimalHistory;
use App\Models\AnimalStatus;
use App\Models\FeedingFrequency;
use App\Models\FeedingPortion;
use App\Models\FeedingType;
use App\Models\TreatmentType;
use App\Models\Veterinarian;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AnimalHistoryTimelineService
{
	/**
	 * Retorna la última entrada de historial por hoja de animal, paginada.
	 */
	public function latestPerAnimalFile(int $perPage = 20): LengthAwarePaginator
	{
		$latestIds = AnimalHistory::select(DB::raw('MAX(id) as id'))
			->groupBy('animal_file_id')
			->pluck('id');

		return AnimalHistory::with(['animalFile.animal'])
			->whereIn('id', $latestIds)
			->orderByDesc('id')
			->paginate($perPage);
	}

	/**
	 * Construye el timeline completo para una hoja de animal.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function buildForAnimalFile(int $animalFileId): array
	{
		$all = AnimalHistory::where('animal_file_id', $animalFileId)
			->orderByDesc('changed_at')
			->orderByDesc('id')
			->get();

		// Cargar catálogos para resolución de nombres
		$statuses = AnimalStatus::all()->keyBy('id');
		$treatments = TreatmentType::all()->keyBy('id');
		$feedTypes = FeedingType::all()->keyBy('id');
		$feedFreqs = FeedingFrequency::all()->keyBy('id');
		$feedPortions = FeedingPortion::all()->keyBy('id');
		$vets = Veterinarian::with('person')->get()->keyBy('id');

		$timeline = [];
		foreach ($all as $h) {
			$item = [
				'id' => $h->id,
				'changed_at' => $h->changed_at,
				'title' => 'Actualización de historial',
				'details' => [],
			];

			$old = $h->valores_antiguos ?? [];
			$new = $h->valores_nuevos ?? [];

			// Cambio de estado
			if (!empty($new['estado'])) {
				$oldName = isset($old['estado']['id']) ? ($statuses[$old['estado']['id']]->nombre ?? ('#'.$old['estado']['id'])) : ($old['estado']['nombre'] ?? null);
				$newName = isset($new['estado']['id']) ? ($statuses[$new['estado']['id']]->nombre ?? ('#'.$new['estado']['id'])) : ($new['estado']['nombre'] ?? null);
				$item['details'][] = [
					'label' => 'Estado',
					'value' => trim(($oldName ? $oldName.' → ' : '') . ($newName ?? '')),
				];
			}

			// Evaluación médica
			if (!empty($new['evaluacion_medica'])) {
				$em = $new['evaluacion_medica'];
				$trat = isset($em['tratamiento_id']) ? ($treatments[$em['tratamiento_id']]->nombre ?? ('#'.$em['tratamiento_id'])) : null;
				$vet = isset($em['veterinario_id']) ? ($vets[$em['veterinario_id']]->person->nombre ?? ('#'.$em['veterinario_id'])) : null;
				$item['details'][] = [
					'label' => 'Evaluación Médica',
					'value' => implode(' | ', array_filter([
						$trat ? ('Tratamiento: '.$trat) : null,
						$vet ? ('Veterinario: '.$vet) : null,
						!empty($em['fecha']) ? ('Fecha: '.$em['fecha']) : null,
					])),
				];
			}

			// Cuidado genérico
			if (!empty($new['care'])) {
				$care = $new['care'];
				$item['details'][] = [
					'label' => 'Cuidado',
					'value' => implode(' | ', array_filter([
						!empty($care['descripcion']) ? $care['descripcion'] : null,
						!empty($care['fecha']) ? ('Fecha: '.$care['fecha']) : null,
					])),
				];
			}

			// Cuidado de alimentación
			if (!empty($new['care_feeding'])) {
				$cf = $new['care_feeding'];
				$tipo = isset($cf['feeding_type_id']) ? ($feedTypes[$cf['feeding_type_id']]->nombre ?? ('#'.$cf['feeding_type_id'])) : null;
				$freq = isset($cf['feeding_frequency_id']) ? ($feedFreqs[$cf['feeding_frequency_id']]->nombre ?? ('#'.$cf['feeding_frequency_id'])) : null;
				$portion = null;
				if (isset($cf['feeding_portion_id'])) {
					$p = $feedPortions[$cf['feeding_portion_id']] ?? null;
					$portion = $p ? ($p->cantidad.' '.$p->unidad) : ('#'.$cf['feeding_portion_id']);
				}
				$item['details'][] = [
					'label' => 'Alimentación',
					'value' => implode(' | ', array_filter([
						$tipo ? ('Tipo: '.$tipo) : null,
						$freq ? ('Frecuencia: '.$freq) : null,
						$portion ? ('Porción: '.$portion) : null,
					])),
				];
			}

			// Observaciones
			if (!empty($h->observaciones)) {
				$obs = is_array($h->observaciones) ? ($h->observaciones['texto'] ?? json_encode($h->observaciones, JSON_UNESCAPED_UNICODE)) : $h->observaciones;
				$item['details'][] = [
					'label' => 'Observaciones',
					'value' => $obs,
				];
			}

			$timeline[] = $item;
		}

		return $timeline;
	}
}


