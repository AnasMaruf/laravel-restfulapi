<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Hash;

class GenerateUser implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \DB::transaction(function(){
            for($counter=0; $counter<1000; $counter++){
                User::create([
                    'name' => 'User '.$counter,
                    'email' => 'user'.$counter.'@gmail.com',
                    'password' => Hash::make('password')
                ]);
            }
        });
    }
}
