<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response     
    {
      return Inertia::render('Submissions/Index', [
        'submissions' => Submission::with('user:id,name')->latest()->get(),
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
        $request->user()->submissions()->create($validated);
        return redirect(route('submissions.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission): RedirectResponse
    {
      Gate::authorize('update', $submission);

      $validated = $request->validate([
          'message' => 'required|string|max:255',
      ]);

      $submission->update($validated);

      return redirect(route('submissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission): RedirectResponse
    {
      Gate::authorize('delete', $submission);

      $submission->delete();
      
      return redirect(route('submissions.index'));
    }
}
