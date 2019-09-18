<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('questions')->truncate();
        DB::table('questions')->insert([
            [
                'user_id' => 4,
                'tag_category_id' => 3,
                'title' => 'seederテスト1',
                'content' => 'seederテスト1',
                'created_at' => Carbon::create(2018, 1, 1),
                'updated_at' => Carbon::create(2018, 9, 1),
            ],
            [
                'user_id' => 4,
                'tag_category_id' => 2,
                'title' => 'seederテスト2',
                'content' => 'seederテスト2',
                'created_at' => Carbon::create(2018, 4, 1),
                'updated_at' => Carbon::create(2018, 10, 1),
            ],
            [
                'user_id' => 4,
                'tag_category_id' => 1,
                'title' => 'seederテスト3',
                'content' => 'seederテスト3',
                'created_at' => Carbon::create(2018, 4, 1),
                'updated_at' => Carbon::create(2018, 10, 1),
            ],
        ]);
    }
}
