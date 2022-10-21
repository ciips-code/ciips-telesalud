<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IssueToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:issue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issue a new API token, creates an user if doesn\'t exists';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $u = User::first();
        if(!$u) {
            $u = new User();
            $u->name = 'OpenEMR';
            $u->email = 'email@example.com';
            $u->password = Hash::make(Str::random(16));
            $u->save();
        }

        $token = $u->createToken('OpenEMR API Token');

        $this->line('New token issued successfully. Use this as a Bearer Token for authentication in API Endpoints:');
        $this->info($token->plainTextToken);
    }
}
