<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\KostProfile;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact page
     */
    public function index()
    {
        $profile = KostProfile::first();
        return view('public.contact', compact('profile'));
    }

    /**
     * Store contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}
