<?php

use App\Livewire\Contact\Form as ContactForm;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('renders the contact page', function () {
    $this->get(route('contact'))->assertOk()->assertSee('Contacto');
});

it('sends an email when the form is valid', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Nicolás')
        ->set('email', 'nicolas@example.com')
        ->set('subject', 'Consulta')
        ->set('message', 'Hola, necesito información sobre materiales.')
        ->call('send')
        ->assertSet('sent', true);

    Mail::assertSent(ContactFormSubmitted::class, function ($mailable) {
        return ($mailable->data['email'] ?? null) === 'nicolas@example.com';
    });
});
