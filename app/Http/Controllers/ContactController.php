<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::all();
        return view('contact.index', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contact.index')->withSuccess('Data deleted');
    }

    public function view($id)
    {
        $contact = Contact::with(['contacts', 'callLogs', 'images'])->findOrFail($id);
        return view('contact.view', compact('contact'));
    }
}