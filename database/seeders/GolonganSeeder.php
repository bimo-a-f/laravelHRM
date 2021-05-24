<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Golongan::factory(15)->create();
    }
}
