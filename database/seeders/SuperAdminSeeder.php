<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ------------------------------------
        // SYSTEM ROLES
        // ------------------------------------
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $technicianRole = Role::firstOrCreate(['name' => 'technician']);
        $workerRole     = Role::firstOrCreate(['name' => 'worker']);

        // ------------------------------------
        // SYSTEM ADMIN USER
        // ------------------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@karting-hq.com'],
            [
                'name'     => 'System Admin',
                'password' => bcrypt('password123'),
            ]
        );

        $admin->assignRole($superAdminRole);

        // ------------------------------------
        // TEAM 1 – "Duracell Racing"
        // ------------------------------------
        $tech1 = User::firstOrCreate(
            ['email' => 'tech1@karting-hq.com'],
            [
                'name'     => 'Technician One',
                'password' => bcrypt('password123'),
            ]
        );

        $tech1->assignRole($technicianRole);

        $team1 = Team::firstOrCreate([
            'name'     => 'Duracell Racing',
            'owner_id' => $tech1->id,
            'is_active' => true,
        ]);

        // worker for team 1
        $worker1 = User::firstOrCreate(
            ['email' => 'worker1@karting-hq.com'],
            [
                'name'     => 'Worker One',
                'password' => bcrypt('password123'),
            ]
        );

        $worker1->assignRole($workerRole);
        $team1->members()->syncWithoutDetaching([
            $tech1->id => ['role_in_team' => 'technician'],
            $worker1->id => ['role_in_team' => 'worker'],
        ]);

        // ------------------------------------
        // TEAM 2 – "RedLine Motors"
        // ------------------------------------
        $tech2 = User::firstOrCreate(
            ['email' => 'tech2@karting-hq.com'],
            [
                'name'     => 'Technician Two',
                'password' => bcrypt('password123'),
            ]
        );

        $tech2->assignRole($technicianRole);

        $team2 = Team::firstOrCreate([
            'name'     => 'RedLine Motors',
            'owner_id' => $tech2->id,
            'is_active' => true,
        ]);

        // worker for team 2
        $worker2 = User::firstOrCreate(
            ['email' => 'worker2@karting-hq.com'],
            [
                'name'     => 'Worker Two',
                'password' => bcrypt('password123'),
            ]
        );

        $worker2->assignRole($workerRole);
        $team2->members()->syncWithoutDetaching([
            $tech2->id => ['role_in_team' => 'technician'],
            $worker2->id => ['role_in_team' => 'worker'],
        ]);
    }
}
