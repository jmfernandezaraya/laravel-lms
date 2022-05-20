<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin')->first();
        if ($user) {
            $user->delete();
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if($user) {
            $user->delete();
        }

        User::create([
            'first_name_en' => 'admin',
            'first_name_ar' => NULL,
            'last_name_en' => '',
            'last_name_ar' => NULL,
            'email' => 'admin@gmail.com',
            'email_verified_at' => "2021-04-17 01:11:11",
            'password' => '$2y$10$Zr8UrvElqOMhQg8id.3ETepu0bwICBpQ39ou4w55JrxOCYPmdno92',
            'user_type' => 'super_admin',
            'remember_token' => 'dc651041150b563af507762af74c8f221e46f3db0fff87f1dda866009a1a851f',
            'image' => NULL,
            'original_image' => NULL,
            'contact' => NULL,
            'liked_school' => '0',
            'created_at' => '2021-03-28 05:58:59',
            'updated_at' => '2021-03-28 05:58:59',
        ]);
    }
}