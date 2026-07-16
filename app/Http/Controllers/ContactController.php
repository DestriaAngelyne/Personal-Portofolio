<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request)
    {
        $contactMessage = ContactMessage::create($request->only('name', 'email', 'message'));

        Mail::to(config('mail.contact_recipient', config('mail.from.address')))
            ->send(new ContactMessageMail($contactMessage));

        return back()->with('success', 'Pesan kamu berhasil terkirim! Saya akan segera membalas.');
    }
}
