<?php

namespace App\Http\Controllers;

use App\Models\AnimalHistory;
use App\Models\FeedingFrequency;
use App\Models\FeedingPortion;
use App\Models\FeedingType;
use Illuminate\View\View;

class AnimalHistoryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(): View
	{
		$histories = AnimalHistory::query()
			->with(['animalFile.animal'])
			->orderByDesc('id')
			->paginate();

		return view('animal-history.index', compact('histories'))
			->with('i', (request()->input('page', 1) - 1) * $histories->perPage());
	}

	public function show(AnimalHistory $animalHistory): View
	{
		$animalHistory->loadMissing(['animalFile.animal']);
		$vals = $animalHistory->valores_nuevos ?? [];
		$care = $vals['care'] ?? [];
		$cf = $vals['care_feeding'] ?? [];
		$type = isset($cf['feeding_type_id']) ? FeedingType::find($cf['feeding_type_id']) : null;
		$freq = isset($cf['feeding_frequency_id']) ? FeedingFrequency::find($cf['feeding_frequency_id']) : null;
		$portion = isset($cf['feeding_portion_id']) ? FeedingPortion::find($cf['feeding_portion_id']) : null;
		$portionText = $portion ? ($portion->cantidad.' '.$portion->unidad) : null;
		$mapped = [
			'care_desc' => $care['descripcion'] ?? null,
			'care_fecha' => $care['fecha'] ?? null,
			'feeding_type' => $type?->nombre,
			'feeding_frequency' => $freq?->nombre,
			'feeding_portion' => $portionText,
		];
		return view('animal-history.show', compact('animalHistory','mapped'));
	}
}


