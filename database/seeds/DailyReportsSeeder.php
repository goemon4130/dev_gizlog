<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DailyReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('daily_reports')->truncate();
        DB::table('daily_reports')->insert([
            [
                'user_id' => 1,
                'title' => 'gizlog',
                'content' => 'seederテスト',
                'reporting_time' => Carbon::now(),
                'created_at' => Carbon::create(2018, 1, 1),
                'updated_at' => Carbon::create(2018, 8, 18),
            ],
            [
                'user_id' => 4,
                'title' => 'gizlog',
                'content' => 'seederテスト',
                'reporting_time' => Carbon::now(),
                'created_at' => Carbon::create(2019, 1, 1),
                'updated_at' => Carbon::create(2019, 8, 18),
            ],
        ]);
    }
}
