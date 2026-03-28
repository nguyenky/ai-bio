<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin
        {email : Admin email address}
        {--name= : Admin display name}
        {--password= : Admin password}';

    protected $description = 'Create or update the single admin user for this application';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $name = (string) ($this->option('name') ?: $this->ask('Admin name', 'Site Owner'));
        $password = (string) ($this->option('password') ?: $this->secret('Admin password'));

        if ($password === '') {
            $this->error('A password is required.');

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        $this->info("Admin user ready: {$user->email}");

        return self::SUCCESS;
    }
}
