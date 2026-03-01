<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature   = 'admin:create';
    protected $description = 'Crea un usuario administrador para el panel de Filament';

    public function handle(): int
    {
        $this->info('Crear usuario administrador');
        $this->line('─────────────────────────────');

        $name = $this->ask('Nombre');

        $email = $this->ask('Correo electrónico');
        $emailValidation = Validator::make(['email' => $email], ['email' => 'required|email|unique:users,email']);
        if ($emailValidation->fails()) {
            $this->error($emailValidation->errors()->first('email'));
            return self::FAILURE;
        }

        $password = $this->secret('Contraseña (mínimo 8 caracteres)');
        if (strlen($password) < 8) {
            $this->error('La contraseña debe tener al menos 8 caracteres.');
            return self::FAILURE;
        }

        $confirm = $this->secret('Confirmar contraseña');
        if ($password !== $confirm) {
            $this->error('Las contraseñas no coinciden.');
            return self::FAILURE;
        }

        User::create([
            'name'              => $name,
            'email'             => $email,
            'password'          => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->newLine();
        $this->info("✓ Usuario «{$name}» creado correctamente.");
        $this->line('  Panel: ' . url('adminprofe'));

        return self::SUCCESS;
    }
}
