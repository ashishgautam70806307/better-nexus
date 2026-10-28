<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Create an administrator account';

    public function handle(): int
    {
        $name = trim((string) $this->ask('Admin name'));

        $email = Str::lower(
            trim((string) $this->ask('Admin email'))
        );

        $password = $this->secret('Admin password');

        $confirmation = $this->secret('Confirm password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                'max:1024',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);

        // Trusted server-side assignment.
        $user->is_admin = true;

        $user->save();

        $this->info('Admin account created successfully.');

        return self::SUCCESS;
    }
}