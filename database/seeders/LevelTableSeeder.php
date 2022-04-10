<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LevelTableSeeder extends Seeder {

    public function run()
    {
        \DB::table('Levels')->delete();

        \DB::table('Levels')->insert([
        	['id' => '1', 'name' => 'A1'],
            ['id' => '2', 'name' => 'A2'],
            ['id' => '3', 'name' => 'B1'],
            ['id' => '4', 'name' => 'B2'],
            ['id' => '5', 'name' => 'C1'],
            ['id' => '6', 'name' => 'C2']
        ]);

        //DB::table('Topics')->insert($topics);

        //User::create(['email' => 'foo@bar.com']);
    }

}