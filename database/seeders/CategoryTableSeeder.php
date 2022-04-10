<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        \DB::table('Categories')->delete();

        \DB::table('Categories')->insert([
                ['id' => '1', 'name' => 'Fonetika', 'name_de' => 'Phonetik'],
                ['id' => '2', 'name' => 'Fonologija', 'name_de' => 'Phonologie'],
                ['id' => '3', 'name' => 'Morfologija', 'name_de' => 'Morphologie'],
                ['id' => '4', 'name' => 'Sintaksė', 'name_de' => 'Syntax'],
                ['id' => '5', 'name' => 'Semantika', 'name_de' => 'Semantik'],
                ['id' => '6', 'name' => 'Pragmatika', 'name_de' => 'Pragmatik']
        ]);

        //DB::table('Topics')->insert($topics);

        //User::create(['email' => 'foo@bar.com']);
    }

}