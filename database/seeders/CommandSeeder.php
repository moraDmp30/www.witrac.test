<?php

namespace Database\Seeders;

use App\Models\Command;
use Illuminate\Database\Seeder;

class CommandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Command::factory()
            ->count(5)
            ->create();
    }
}
