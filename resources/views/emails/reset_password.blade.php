{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
@component('mail::message')
# Réinitialisation de mot de passe

Bonjour {{ $user->name }},

Vous avez reçu cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.

@component('mail::button', ['url' => $resetUrl])
Réinitialiser le mot de passe
@endcomponent

Si vous n'avez pas demandé la réinitialisation de mot de passe, aucune autre action n'est requise.

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent

