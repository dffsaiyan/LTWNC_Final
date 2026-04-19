<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            // AdminUserSeeder::class, // Nên tách ra như thế này
        ]);

        // Tạo Admin duy nhất một lần bằng thông tin từ môi trường
        if (env('ADMIN_EMAIL')) {
            User::updateOrCreate(
                ['email' => env('ADMIN_EMAIL')],
                [
                    'name' => env('ADMIN_NAME', 'Administrator'),
                    'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
                    'is_admin' => true,
                ]
            );
        }
    }
}
