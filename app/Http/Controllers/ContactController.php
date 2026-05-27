<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // GET /contacts
    public function index(Request $request)
    {
        $query = Contact::available()->orderBy('city')->orderBy('name');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('city')) {
            $query->inCity($request->city);
        }

        $contacts = $query->paginate(12)->withQueryString();
        $types = ['hospital', 'police', 'fire', 'ngo', 'helpline'];
        $cities = Contact::distinct()->orderBy('city')->pluck('city');

        return view('contacts.index', compact('contacts', 'types', 'cities'));
    }

    // GET /contacts/{id}
    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    // API: GET /api/contacts — returns JSON (demonstrates JSON response)
    public function apiIndex(Request $request)
    {
        $contacts = Contact::available()
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->city, fn($q) => $q->inCity($request->city))
            ->get(['id', 'name', 'type', 'phone', 'city', 'state', 'is_available']);

        return response()->json([
            'success' => true,
            'data'    => $contacts,
            'count'   => $contacts->count(),
        ]);
    }
}
