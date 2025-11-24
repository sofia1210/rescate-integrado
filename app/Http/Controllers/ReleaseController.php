<?php

namespace App\Http\Controllers;

use App\Models\Release;
use App\Models\AnimalFile;
use App\Models\AnimalType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReleaseRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\Animal\AnimalReleaseTransactionalService;

class ReleaseController extends Controller
{
    public function __construct(
        private readonly AnimalReleaseTransactionalService $releaseService
    ) {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $releases = Release::paginate();

        return view('release.index', compact('releases'))
            ->with('i', ($request->input('page', 1) - 1) * $releases->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $release = new Release();
        $animalFiles = AnimalFile::query()
            ->join('animal_types', 'animal_files.tipo_id', '=', 'animal_types.id')
            ->leftJoin('releases', 'releases.animal_file_id', '=', 'animal_files.id')
            ->join('animals', 'animal_files.animal_id', '=', 'animals.id')
            ->where('animal_types.permite_liberacion', true)
            ->whereNull('releases.animal_file_id')
            ->orderBy('animals.nombre')
            ->get(['animal_files.id as id', 'animals.nombre as nombre']);

        return view('release.create', compact('release','animalFiles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReleaseRequest $request): RedirectResponse
    {
        try {
            $this->releaseService->create($request->validated());
        } catch (\DomainException $e) {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            return Redirect::back()->withInput()->with('error', 'No se pudo registrar la liberación: '.$e->getMessage());
        }

        return Redirect::route('releases.index')
            ->with('success', 'Liberación creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $release = Release::find($id);

        return view('release.show', compact('release'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $release = Release::find($id);
        $animalFiles = AnimalFile::query()
            ->join('animal_types', 'animal_files.tipo_id', '=', 'animal_types.id')
            ->leftJoin('releases', 'releases.animal_file_id', '=', 'animal_files.id')
            ->join('animals', 'animal_files.animal_id', '=', 'animals.id')
            ->where('animal_types.permite_liberacion', true)
            ->where(function($q) use ($release) {
                $q->whereNull('releases.animal_file_id')
                  ->orWhere('releases.id', $release->id);
            })
            ->orderBy('animals.nombre')
            ->get(['animal_files.id as id', 'animals.nombre as nombre']);

        return view('release.edit', compact('release','animalFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReleaseRequest $request, Release $release): RedirectResponse
    {
        $release->update($request->validated());

        return Redirect::route('releases.index')
            ->with('success', 'Liberación actualizada correctamente');
    }

    public function destroy($id): RedirectResponse
    {
        Release::find($id)->delete();

        return Redirect::route('releases.index')
            ->with('success', 'Liberación eliminada correctamente');
    }
}
