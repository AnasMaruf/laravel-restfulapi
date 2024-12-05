<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> Hash::make('password')
        ]);

        for ($i=1; $i <=100 ; $i++) {
            $payload = [
                'name'=>'product'.$i,
                'description'=>'description'.$i,
                'price'=>$i*10,
                'user_id'=>1
            ];
            Product::create([
                'name' => $payload['name'],
                'description' => $payload['description'],
                'price'=>$payload['price'],
                'user_id'=>$payload['user_id']
            ]);
        }
    }
}
