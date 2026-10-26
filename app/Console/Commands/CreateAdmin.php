<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {--name= : Nama admin} {--email= : Email login}';
    protected $description = 'Membuat (atau mengganti password) akun admin. Password diminta secara interaktif.';

    public function handle(): int
    {
        $name = $this->option('name') ?: $this->ask('Nama admin');
        $email = $this->option('email') ?: $this->ask('Email admin');
        $password = $this->secret('Password (minimal 12 karakter)');
        $confirm = $this->secret('Ulangi password');

        $v = Validator::make(
            compact('name', 'email', 'password') + ['password_confirmation' => $confirm],
            ['name' => 'required|string|max:100', 'email' => 'required|email', 'password' => 'required|string|min:12|confirmed']
        );
        if ($v->fails()) {
            foreach ($v->errors()->all() as $e) {
                $this->error($e);
            }

            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();
        if ($user && ! $this->confirm('Email sudah terdaftar. Ganti password akun ini?')) {
            return self::FAILURE;
        }
        User::updateOrCreate(['email' => $email], ['name' => $name, 'password' => Hash::make($password)]);
        $this->info($user ? 'Password admin diperbarui.' : 'Akun admin dibuat. Login di /admin');

        return self::SUCCESS;
    }
}
