<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChecklistRequest;
use App\Models\Checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    // GET /checklists
    public function index()
    {
        $checklists = auth()->user()->checklists()->latest()->get();
        return view('checklists.index', compact('checklists'));
    }

    // GET /checklists/create
    public function create()
    {
        $types = ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic'];
        return view('checklists.create', compact('types'));
    }

    // POST /checklists
    public function store(ChecklistRequest $request)
    {
        $defaultItems = $this->defaultItems($request->disaster_type);

        $checklist = auth()->user()->checklists()->create([
            'title'         => $request->title,
            'disaster_type' => $request->disaster_type,
            'items'         => $defaultItems,
        ]);

        return redirect()->route('checklists.show', $checklist)
            ->with('success', 'Checklist created!');
    }

    // GET /checklists/{checklist}
    public function show(Checklist $checklist)
    {
        $this->authorize('view', $checklist);
        return view('checklists.show', compact('checklist'));
    }

    // PATCH /checklists/{checklist}/toggle/{index}
    public function toggle(Checklist $checklist, int $index)
    {
        $this->authorize('update', $checklist);

        $items = $checklist->items;
        if (isset($items[$index])) {
            $items[$index]['checked'] = ! ($items[$index]['checked'] ?? false);
        }
        $checklist->update(['items' => $items]);

        return response()->json([
            'checked'    => $items[$index]['checked'],
            'completion' => $checklist->completionPercent(),
        ]);
    }

    // DELETE /checklists/{checklist}
    public function destroy(Checklist $checklist)
    {
        $this->authorize('delete', $checklist);
        $checklist->delete();

        return redirect()->route('checklists.index')->with('success', 'Checklist deleted.');
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function defaultItems(string $type): array
    {
        $items = match ($type) {
            'flood' => [
                'Store 3 days of drinking water',
                'Move valuables to higher floors',
                'Know your nearest evacuation route',
                'Keep waterproof bags for documents',
                'Prepare a battery-powered radio',
                'Check emergency contact numbers',
            ],
            'earthquake' => [
                'Secure heavy furniture to walls',
                'Keep an emergency kit under the bed',
                'Learn Drop, Cover, Hold On technique',
                'Know location of gas/water shutoffs',
                'Identify safe spots in each room',
                'Keep shoes near the bed',
            ],
            'cyclone' => [
                'Board up windows and doors',
                'Charge all devices and power banks',
                'Store a week of food and water',
                'Identify nearest cyclone shelter',
                'Secure outdoor furniture',
                'Keep battery radio for updates',
            ],
            'fire' => [
                'Install smoke detectors on every floor',
                'Plan two escape routes per room',
                'Keep fire extinguisher accessible',
                'Practice fire drill with family',
                'Keep lighters away from children',
                'Know the fire brigade number: 101',
            ],
            'landslide' => [
                'Monitor weather and slope conditions',
                'Plan evacuation route away from slopes',
                'Keep emergency kit ready',
                'Watch for cracking sounds or tilting',
                'Contact local authorities if at risk',
                'Avoid building on steep slopes',
            ],
            'pandemic' => [
                'Stock 30-day supply of medicines',
                'Keep N95 masks and sanitizer ready',
                'Identify isolation room in home',
                'Store two weeks of non-perishable food',
                'Keep thermometer and oximeter handy',
                'Stay updated on official health advisories',
            ],
            default => ['Be prepared', 'Have a plan', 'Stay informed'],
        };

        return array_map(fn($label) => ['label' => $label, 'checked' => false], $items);
    }
}
