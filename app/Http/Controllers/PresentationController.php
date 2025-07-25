<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresentationCompletionRequest;
use App\Models\PresentationCompletion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PresentationController extends Controller
{
    /**
     * Display the presentation.
     */
    public function index()
    {
        $completionCount = PresentationCompletion::count();
        
        return Inertia::render('presentation', [
            'completionCount' => $completionCount
        ]);
    }
    
    /**
     * Store a presentation completion.
     */
    public function store(StorePresentationCompletionRequest $request)
    {
        // Check if this session has already completed the presentation
        $existingCompletion = PresentationCompletion::where('session_id', $request->validated()['session_id'])
            ->first();
            
        if (!$existingCompletion) {
            PresentationCompletion::create([
                'session_id' => $request->validated()['session_id'],
                'completed_at' => now(),
            ]);
        }
        
        $completionCount = PresentationCompletion::count();
        
        return Inertia::render('presentation', [
            'completionCount' => $completionCount
        ]);
    }
}