<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterRequest;
use App\Models\Disaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DisasterController extends Controller
{
    // GET /disasters
    public function index(Request $request)
    {
        $query = Disaster::active()->latest();

        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($q2) => $q2
                ->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->orWhere('region', 'like', "%{$q}%")
            );
        }

        $disasters = $query->paginate(9)->withQueryString();
        $types = ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic'];

        return view('disasters.index', compact('disasters', 'types'));
    }

    // GET /disasters/{slug}
    public function show(Disaster $disaster)
    {
        // Increment view count — demonstrates Eloquent update
        $disaster->increment('views');

        $related = Disaster::active()
            ->ofType($disaster->type)
            ->where('id', '!=', $disaster->id)
            ->limit(3)
            ->get();

        return view('disasters.show', compact('disaster', 'related'));
    }

    // GET /disasters/create
    public function create()
    {
        $types     = ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic'];
        $severities = ['low', 'medium', 'high', 'critical'];
        return view('disasters.create', compact('types', 'severities'));
    }

    // POST /disasters
    public function store(DisasterRequest $request)
    {
        Disaster::create(array_merge(
            $request->validated(),
            ['slug' => Str::slug($request->name) . '-' . time(),
             'created_by' => auth()->id()]
        ));

        return redirect()->route('disasters.index')
            ->with('success', __('messages.disaster_created'));
    }

    // GET /disasters/{slug}/edit
    public function edit(Disaster $disaster)
    {
        $types     = ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic'];
        $severities = ['low', 'medium', 'high', 'critical'];
        return view('disasters.edit', compact('disaster', 'types', 'severities'));
    }

    // PUT /disasters/{slug}
    public function update(DisasterRequest $request, Disaster $disaster)
    {
        $disaster->update($request->validated());

        return redirect()->route('disasters.show', $disaster)
            ->with('success', __('messages.disaster_updated'));
    }

    // DELETE /disasters/{slug}
    public function destroy(Disaster $disaster)
    {
        $disaster->delete();

        return redirect()->route('disasters.index')
            ->with('success', __('messages.disaster_deleted'));
    }
}
