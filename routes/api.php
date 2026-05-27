<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DisasterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public API — no auth required, throttled
Route::middleware('throttle:60,1')->group(function () {

    // GET /api/disasters
    Route::get('/disasters', function () {
        $disasters = \App\Models\Disaster::active()
            ->select('id', 'slug', 'name', 'type', 'severity', 'region', 'views')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $disasters,
        ]);
    });

    // GET /api/disasters/{slug}
    Route::get('/disasters/{slug}', function (string $slug) {
        $disaster = \App\Models\Disaster::active()->where('slug', $slug)->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $disaster,
        ]);
    });

    // GET /api/contacts
    Route::get('/contacts', [ContactController::class, 'apiIndex']);

    // GET /api/stats
    Route::get('/stats', function () {
        return response()->json([
            'success' => true,
            'data'    => [
                'disasters' => \App\Models\Disaster::active()->count(),
                'contacts'  => \App\Models\Contact::available()->count(),
                'tips'      => \App\Models\Tip::approved()->count(),
            ],
        ]);
    });
});

// Authenticated API
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('/my/checklists', function (Request $request) {
        return response()->json([
            'success' => true,
            'data'    => $request->user()->checklists()->latest()->get(),
        ]);
    });
});
