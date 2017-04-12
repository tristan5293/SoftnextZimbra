<?php

use Illuminate\Database\Seeder;

use App\TimeServerList;

class TimeServerListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeServerList::create([
            'server_name' => 'tw.pool.ntp.org,tick.stdtime.gov.tw,time-a.nist.gov'
        ]);
    }
}
