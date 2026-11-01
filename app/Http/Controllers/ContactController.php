<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $saved = ContactMessage::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'type'       => $data['type'],
            'message'    => $data['message'],
            'ip_address' => $request->ip(),
        ]);

        $notify = config('portfolio.notify_email');

        if ($notify) {
            try {
                Mail::raw(
                    "New portfolio message (#{$saved->id})\n\n"
                    . "From: {$saved->name} <{$saved->email}>\n"
                    . 'Type: ' . (config('portfolio.contact_types')[$saved->type] ?? $saved->type) . "\n\n"
                    . $saved->message,
                    function ($mail) use ($notify, $saved) {
                        $mail->to($notify)
                            ->replyTo($saved->email, $saved->name)
                            ->subject('Portfolio message from ' . $saved->name);
                    }
                );
            } catch (\Throwable $e) {
                // The message is already stored, so a mail problem must not lose it.
                Log::warning('Portfolio notify mail failed: ' . $e->getMessage());
            }
        }

        return redirect(route('home') . '#contact')
            ->with('status', 'Thank you, ' . $saved->name . '. Your message was received and I will reply by email.');
    }
}
