<?php

namespace App\Livewire\Contact;

use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Form extends Component
{
    public string $name = '';

    public string $email = '';

    public ?string $subject = '';

    public string $message = '';

    public string $website = ''; // honeypot

    public bool $sent = false;

    protected array $rules = [
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:150'],
        'subject' => ['nullable', 'string', 'max:150'],
        'message' => ['required', 'string', 'min:10', 'max:5000'],
        'website' => ['nullable', 'string', 'size:0'], // honeypot debe quedar vacío
    ];

    protected array $messages = [
        'name.required' => 'Ingresa tu nombre.',
        'email.required' => 'Ingresa tu correo.',
        'email.email' => 'El correo no es válido.',
        'message.required' => 'Escribe tu mensaje.',
        'message.min' => 'Tu mensaje es muy corto.',
        'website.size' => 'Ups, algo salió mal.', // si el bot escribe, caerá aquí
    ];

    public function send(): void
    {
        // Validaciones
        $validated = $this->validate();

        // Si el honeypot viene con contenido, corta (opcional: loguear)
        if (! empty($this->website)) {
            // Silenciosamente consideramos enviado (evita feedback para bots)
            $this->sent = true;

            return;
        }

        $payload = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject ?? '',
            'message' => $this->message,
        ];

        // Enviar email
        $to = config('mail.contact_to');
        Mail::to($to)->send(new ContactFormSubmitted($payload));

        // Limpiar y confirmar
        $this->reset(['name', 'email', 'subject', 'message', 'website']);
        $this->sent = true;
        session()->flash('contact_ok', '¡Gracias! Tu mensaje fue enviado correctamente.');
    }

    public function render()
    {
        return view('livewire.contact.form')->title('Contacto');
    }
}
