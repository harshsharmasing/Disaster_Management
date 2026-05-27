<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Disaster;
use App\Models\Tip;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured   = Disaster::active()->orderByDesc('views')->limit(3)->get();
        $tipCount   = Tip::approved()->count();
        $contactCount = Contact::count();

        // Share the locale with the view (demonstrates View::share / view()->with)
        return view('home', compact('featured', 'tipCount', 'contactCount'));
    }

    // Language switcher — demonstrates session storage + redirect
    public function setLocale(Request $request, string $locale)
    {
        $allowed = ['en'];

        if (in_array($locale, $allowed)) {
            session(['locale' => $locale]);
        }

        return redirect()->back()->with('success', __('messages.language_changed'));
    }
}
