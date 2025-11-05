<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $reports = Report::paginate();

        return view('report.index', compact('reports'))
            ->with('i', ($request->input('page', 1) - 1) * $reports->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $report = new Report();

        return view('report.create', compact('report'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request): RedirectResponse
    {
        Report::create($request->validated());

        return Redirect::route('reports.index')
            ->with('success', 'Report created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $report = Report::find($id);

        return view('report.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $report = Report::find($id);

        return view('report.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReportRequest $request, Report $report): RedirectResponse
    {
        $report->update($request->validated());

        return Redirect::route('reports.index')
            ->with('success', 'Report updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Report::find($id)->delete();

        return Redirect::route('reports.index')
            ->with('success', 'Report deleted successfully');
    }
}
