<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\AnimalWithFileRequest;
use App\Models\Animal;
use App\Models\AnimalFile;
use App\Models\AnimalStatus;
use App\Models\AnimalType;
use App\Models\Report;
use App\Models\Species;
use App\Services\Animal\AnimalTransactionalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AnimalTransactionalController extends Controller
{
	public function __construct(
		private readonly AnimalTransactionalService $service
	) {
		$this->middleware('auth');
	}

	/**
	 * Formulario combinado para crear Animal + Hoja de Animal en una sola operación.
	 */
	public function create(): View
	{
		$animal = new Animal();
		$animalFile = new AnimalFile();

		// Datos requeridos por el form de Animal
		$reports = Report::query()
			->where('aprobado', 1)
			->leftJoin('animals', 'animals.reporte_id', '=', 'reports.id')
			->groupBy('reports.id', 'reports.cantidad_animales')
			->havingRaw('COUNT(animals.id) < COALESCE(reports.cantidad_animales, 1)')
			->orderByDesc('reports.id')
			->get(['reports.id']);

		// Datos requeridos por el form de AnimalFile (salvo animales)
		$animalTypes = AnimalType::orderBy('nombre')->get(['id','nombre']);
		$species = Species::orderBy('nombre')->get(['id','nombre']);
		$animalStatuses = AnimalStatus::orderBy('nombre')->get(['id','nombre']);

		return view('transactions.animal.create', compact(
			'animal',
			'animalFile',
			'reports',
			'animalTypes',
			'species',
			'animalStatuses'
		));
	}

	/**
	 * Persiste Animal + Hoja de Animal (transaccional).
	 */
	public function store(AnimalWithFileRequest $request): RedirectResponse
	{
		$animalData = $request->only(['nombre','sexo','descripcion','reporte_id']);
		$animalFileData = $request->only(['tipo_id','especie_id','raza_id','estado_id']);
		$image = $request->file('imagen');

		$this->service->createWithFile($animalData, $animalFileData, $image);

		return Redirect::route('animal-files.index')
			->with('success', 'Animal y Hoja creados correctamente en una transacción.');
	}
}


