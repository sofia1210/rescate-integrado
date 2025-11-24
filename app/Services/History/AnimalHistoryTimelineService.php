<?php

namespace App\Services\History;

use App\Models\AnimalHistory;
use App\Models\AnimalStatus;
use App\Models\FeedingFrequency;
use App\Models\FeedingPortion;
use App\Models\FeedingType;
use App\Models\TreatmentType;
use App\Models\Veterinarian;
use App\Models\Care;
use App\Models\MedicalEvaluation;
use App\Models\Person;
use App\Models\Center;
use Illuminate\Support\Carbon;
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
			$changed = $h->changed_at ? Carbon::parse($h->changed_at) : null;
			$changedDate = $changed ? $changed->format('d-m-Y') : null;
			$changedTime = $changed ? $changed->format('H:i') : null;
			$item = [
				'id' => $h->id,
				'changed_at' => trim(($changedDate ?? '') . ($changedTime ? ' '.$changedTime : '')),
				'title' => 'Actualización de historial',
				'details' => [],
			];

			$old = $h->valores_antiguos ?? [];
			$new = $h->valores_nuevos ?? [];
			$imageUrl = null;

			// Línea estándar de fecha y hora
			if ($changedDate || $changedTime) {
				$item['details'][] = [
					'label' => 'Fecha/Hora',
					'value' => trim('Fecha: '.($changedDate ?? '-') . '    ' . 'Hora: '.($changedTime ?? '-')),
				];
			}

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
				// intentar obtener imagen desde la evaluación
				if (!empty($em['id'])) {
					$me = MedicalEvaluation::find($em['id']);
					if ($me && $me->imagen_url) {
						$imageUrl = $me->imagen_url;
					}
				}
				$item['details'][] = [
					'label' => 'Evaluación Médica',
					'value' => implode(' | ', array_filter([
						$trat ? ('Tratamiento: '.$trat) : null,
						$vet ? ('Veterinario: '.$vet) : null,
					])),
				];
			}

			// Cuidado genérico
			if (!empty($new['care'])) {
				$care = $new['care'];
				// intentar obtener imagen desde el cuidado
				if (!empty($care['id'])) {
					$c = Care::find($care['id']);
					if ($c && $c->imagen_url) {
						$imageUrl = $c->imagen_url;
					}
				}
				$careTypeText = null;
				if (!empty($care['tipo_cuidado_id'])) {
					// resolución perezosa: traer nombre desde DB solo si aparece en el historial (evita otro catálogo)
					$careTypeText = 'Tipo: #'.$care['tipo_cuidado_id'];
				}
				$item['details'][] = [
					'label' => 'Cuidado',
					'value' => implode(' | ', array_filter([
						!empty($care['descripcion']) ? $care['descripcion'] : null,
						$careTypeText,
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

			// Traslado
			if (!empty($new['transfer'])) {
				$tr = $new['transfer'];
				$personName = isset($tr['persona_id']) ? (Person::find($tr['persona_id'])->nombre ?? ('#'.$tr['persona_id'])) : null;
				$centerName = isset($tr['centro_id']) ? (Center::find($tr['centro_id'])->nombre ?? ('#'.$tr['centro_id'])) : null;
				$item['details'][] = [
					'label' => 'Traslado',
					'value' => implode(' | ', array_filter([
						$personName ? ('Persona: '.$personName) : null,
						$centerName ? ('Centro: '.$centerName) : null,
						isset($tr['primer_traslado']) ? ('Primer traslado: '.($tr['primer_traslado'] ? 'Sí' : 'No')) : null,
						!empty($tr['observaciones']) ? ('Obs: '.$tr['observaciones']) : null,
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

			if ($imageUrl) {
				$item['image_url'] = $imageUrl;
			}

			$timeline[] = $item;
		}

		return $timeline;
	}
}


