<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\AnimalFile;
use App\Models\AnimalType;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AdoptionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdoptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $adoptions = Adoption::paginate();

        return view('adoption.index', compact('adoptions'))
            ->with('i', ($request->input('page', 1) - 1) * $adoptions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $adoption = new Adoption();
        $people = Person::orderBy('nombre')->get(['id','nombre']);
        $animalFiles = AnimalFile::query()
            ->join('animal_types', 'animal_files.tipo_id', '=', 'animal_types.id')
            ->leftJoin('adoptions', 'adoptions.animal_file_id', '=', 'animal_files.id')
            ->join('animals', 'animal_files.animal_id', '=', 'animals.id')
            ->where('animal_types.permite_adopcion', true)
            ->whereNull('adoptions.animal_file_id')
            ->orderBy('animals.nombre')
            ->get(['animal_files.id as id', 'animals.nombre as nombre']);
        return view('adoption.create', compact('adoption','people','animalFiles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdoptionRequest $request): RedirectResponse
    {
        Adoption::create($request->validated());

        return Redirect::route('adoptions.index')
            ->with('success', 'Adopción creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $adoption = Adoption::find($id);

        return view('adoption.show', compact('adoption'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $adoption = Adoption::find($id);
        $people = Person::orderBy('nombre')->get(['id','nombre']);
        $animalFiles = AnimalFile::query()
            ->join('animal_types', 'animal_files.tipo_id', '=', 'animal_types.id')
            ->leftJoin('adoptions', 'adoptions.animal_file_id', '=', 'animal_files.id')
            ->join('animals', 'animal_files.animal_id', '=', 'animals.id')
            ->where('animal_types.permite_adopcion', true)
            ->where(function($q) use ($adoption) {
                $q->whereNull('adoptions.animal_file_id')
                  ->orWhere('adoptions.id', $adoption->id);
            })
            ->orderBy('animals.nombre')
            ->get(['animal_files.id as id', 'animals.nombre as nombre']);
        return view('adoption.edit', compact('adoption','people','animalFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdoptionRequest $request, Adoption $adoption): RedirectResponse
    {
        $adoption->update($request->validated());

        return Redirect::route('adoptions.index')
            ->with('success', 'Adopción actualizada exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        Adoption::find($id)->delete();

        return Redirect::route('adoptions.index')
            ->with('success', 'Adopción eliminada correctamente');
    }
}
