<?php

namespace Database\Seeders;

use App\Models\Pacient;
use Illuminate\Database\Seeder;

class PacientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pacient::factory(30)->create();
    }
}
