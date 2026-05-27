<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipRequest;
use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    // GET /tips
    public function index(Request $request)
    {
        $query = Tip::approved()->with('user')->latest();

        if ($request->filled('type')) {
            $query->where('disaster_type', $request->type);
        }

        $tips  = $query->paginate(10)->withQueryString();
        $types = ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic', 'general'];

        return view('tips.index', compact('tips', 'types'));
    }

    // GET /tips/{tip}
    public function show(Tip $tip)
    {
        abort_if(! $tip->is_approved, 404);
        return view('tips.show', compact('tip'));
    }

    // GET /tips/create
    public function create()
    {
        $types = ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic', 'general'];
        return view('tips.create', compact('types'));
    }

    // POST /tips
    public function store(TipRequest $request)
    {
        // Old input is automatically available via $request->old() in blade
        $tip = auth()->user()->tips()->create($request->validated());

        return redirect()->route('tips.index')
            ->with('success', 'Your tip has been submitted for review. Thank you!');
    }

    // DELETE /tips/{tip}
    public function destroy(Tip $tip)
    {
        abort_if(! auth()->user()->isAdmin() && $tip->user_id !== auth()->id(), 403);
        $tip->delete();

        return redirect()->route('tips.index')->with('success', 'Tip deleted.');
    }

    // PATCH /tips/{tip}/approve  (admin only)
    public function approve(Tip $tip)
    {
        abort_if(! auth()->user()->isAdmin(), 403);
        $tip->update(['is_approved' => true]);

        return back()->with('success', 'Tip approved!');
    }
}
