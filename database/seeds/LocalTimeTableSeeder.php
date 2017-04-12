<?php

use Illuminate\Database\Seeder;

use App\LocalTime;

class LocalTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LocalTime::create([
            'server_name' => 'tw.pool.ntp.org'
        ]);
    }
}
