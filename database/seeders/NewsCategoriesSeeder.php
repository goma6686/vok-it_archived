<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('news_categories')->delete();

        \DB::table('news_categories')->insert([
        	['id' => '1', 'name' => 'VU naujienos', 'name_de' => 'VU-Neuigkeiten'],
        	['id' => '2', 'name' => 'Įdomybės', 'name_de' => 'Interessant'],
            ['id' => '3', 'name' => 'Studentų darbai', 'name_de' => 'Studentenarbeit']
        ]);
    }
}
