<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bouncer;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Bouncer::role()->firstOrCreate([ 'name' => 'superadmin', 'title' => 'Super Admin', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'staff', 'title' => 'Staff', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'customer', 'title' => 'Customer', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'view', 'title' => 'Viewer', ]);
    }
}
