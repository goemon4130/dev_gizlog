<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->truncate();
        DB::table('comments')->insert([
            [
                'user_id' => 4,
                'question_id' => 1,
                'comment' => 'seederテスト',
                'created_at' => Carbon::create(2018, 1, 1),
                'updated_at' => Carbon::create(2018, 9, 1),
            ],
            [
                'user_id' => 4,
                'question_id' => 1,
                'comment' => 'seederテスト',
                'created_at' => Carbon::create(2018, 4, 1),
                'updated_at' => Carbon::create(2018, 10, 1),
            ],
            [
                'user_id' => 4,
                'question_id' => 2,
                'comment' => 'seederテスト',
                'created_at' => Carbon::create(2018, 4, 1),
                'updated_at' => Carbon::create(2018, 10, 1),
            ],
            [
                'user_id' => 4,
                'question_id' => 3,
                'comment' => 'seederテスト',
                'created_at' => Carbon::create(2018, 4, 1),
                'updated_at' => Carbon::create(2018, 10, 1),
            ],
        ]);
    }
}
