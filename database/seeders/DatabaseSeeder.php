<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use function Termwind\ask;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('media-library:clean');

        $password = env('ADMIN_PASSWORD') ?: ask('Admin password? ');
        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make($password),
        ]);
        printf("Admin credentials:  admin / %s\n", $password);

        $users = User::factory(10)->create();
        $user = $users[0];

        Category::factory(5)
            ->for($user, 'author')
            ->has(Topic::factory(20)
                ->for($user, 'author')
                ->has(Comment::factory(10)
                    ->for($user, 'author')))
            ->create();
    }
}
