<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LibrarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $librarian = User::create([
            'email' => 'librarian@brs.com',
            'name' => 'Librarian',
            'password' => Hash::make('password!'),
            'is_librarian' => true
        ]);
        $user = User::create([
            'email' => 'reader@brs.com',
            'name' => 'Reader',
            'password' => Hash::make('password!'),
            'is_librarian' => false
        ]);
    }
}
