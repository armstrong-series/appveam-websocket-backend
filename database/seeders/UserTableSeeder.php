<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Services\RoleService;
use App\Enums\RoleEnum;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function __construct(
        protected RoleService $roleService
    ) {}


    public function run(): void
    {


        $adminUser = User::factory()->create(
            [
                'name'   => 'Jones Calvin',
                'email'  => 'admin@appveam.co',
                'status' => 'active',
            ]
        );
        $this->roleService->assignRole($adminUser, RoleEnum::Admin->value);

        $customerUser = User::factory()->create([
            'name'   => 'Eleanor Armstrong',
            'email'  => 'eleanor.armstrong@appveam.co',
            'status' => 'active',
        ]);
        $this->roleService->assignRole($customerUser, RoleEnum::Customer->value);

        $support = User::factory()->create([
            'name'   => 'Jonathan Stoves',
            'email'  => 'jonathanstoves@appveam.co',
            'status' => 'active',
        ]);
        $this->roleService->assignRole($support, RoleEnum::Support->value);


        User::factory()->count(3)->create(['status' => 'active'])
            ->each(fn($user) => $this->roleService->assignRole($user, RoleEnum::User->value));

        User::factory()->count(3)->create(['status' => 'locked'])
            ->each(fn($user) => $this->roleService->assignRole($user, RoleEnum::User->value));
    }
}