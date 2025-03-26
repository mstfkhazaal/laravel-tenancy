<?php

namespace Database\Seeders;

use App\Models\CentralUser;
use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws TenantCouldNotBeIdentifiedById
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $tenant = Tenant::create();

        $tenant->domains()->create([
            'domain' => 'foo',
        ]);
        tenancy()->initialize($tenant);
        $userCentral = CentralUser::create([
            'global_id'=>uniqid(),
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' =>Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'global_id' => $userCentral->global_id,
            'name' => $userCentral->name,
            'email' => $userCentral->email,
            'password' => $userCentral->password,
        ]);


    }
}
