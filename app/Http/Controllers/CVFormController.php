<?php

namespace App\Http\Controllers;

use App\Models\CVForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCvFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class CVFormController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cvs = auth()->user()->CVForm()
            ->orderBy('last_edited_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('cv.index', compact('cvs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cv.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCvFormRequest $request)
    {
        try {
            $cvForm = CVForm::create($request->validated());

            return redirect()->route('cv.show', $cvForm)
                ->with('success', 'CV created successfully!');
        } catch (\Exception $e) {
            Log::error('CV creation failed', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CVForm $cv)
    {
        $this->authorize('view', $cv);

        return view('cv.show', ['cv' => $cv]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CVForm $cv)
    {
        $this->authorize('update', $cv);

        return view('cv.edit', ['cv' => $cv]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCvFormRequest $request, CVForm $cv)
    {
        $this->authorize('update', $cv);

        try {
            
            $cv->update($request->validated());

            return redirect()->route('cv.show', $cv)
                ->with('success', 'CV updated successfully!');
        } catch (\Exception $e) {
            Log::error('CV update failed', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CVForm $cv)
    {
        $this->authorize('delete', $cv);

        $cv->delete();

        return redirect()->route('cv.index')
            ->with('success', 'CV deleted.');
    }
}
