<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;

class AdminSeeder extends Seeder {
    public function run(): void {
        $admin = User::updateOrCreate([
            'id' => 1,
            'name' => 'admin',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(env('DEFAULT_SEED_PASSWORD', '123')),
            'remember_token' => Str::random(10),
        ]);

        $adminRole = Role::firstWhere('name', 'admin');
        $adminRole->users()->attach($admin);
        $adminRole->managers()->attach($admin);
        //$admin->roles()->attach(Role::firstWhere('name', 'admin'));
    }
}
