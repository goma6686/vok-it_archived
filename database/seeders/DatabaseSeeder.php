<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call('TopicTableSeeder');

        $this->command->info('Topic table seeded!');
    }
}

class TopicTableSeeder extends Seeder {

    public function run()
    {
        DB::table('Topics')->delete();

        DB::table('Topics')->insert([
        	['id' => '1', 'name' => 'Apie save', 'name_de' => 'Informationen zur Person'],
        	['id' => '2', 'name' => 'Gyvenamoji vieta', 'name_de' => 'Wohnen'],
        	['id' => '3', 'name' => 'Gamta, ekologija', 'name_de' => 'Umwelt'],
        	['id' => '4', 'name' => 'Kelionės, transportas', 'name_de' => 'Reisen und Verkehr'],
        	['id' => '5', 'name' => 'Maitinimas', 'name_de' => 'Verpflegung'],
        	['id' => '6', 'name' => 'Pirkiniai', 'name_de' => 'Einkaufen'],
        	['id' => '7', 'name' => 'Paslaugos', 'name_de' => 'Öffenliche und private Dienstleistungen'],
        	['id' => '8', 'name' => 'Kūno dalys, sveikata, higiena', 'name_de' => 'Körper, Gesundheit und Hygiene'],
        	['id' => '9', 'name' => 'Profesinė aplinka', 'name_de' => 'Arbeit und Beruf'],
        	['id' => '10', 'name' => 'Mokykla, mokymasis', 'name_de' => 'Ausbildung und Schule'],
        	['id' => '11', 'name' => 'Užsienio kalbų mokymasis ir mokėjimas', 'name_de' => 'Fremdsprachen'],
        	['id' => '12', 'name' => 'Laisvalaikis, pomėgiai', 'name_de' => 'Freizeit und Unterhaltung'],
        	['id' => '13', 'name' => 'Tarpasmeniniai santykiai ir šeima', 'name_de' => 'Persönliche Beziehungen und Familie'],
        	['id' => '14', 'name' => 'Politika ir visuomenė', 'name_de' => 'Politik und Gesellschaft']
        ]);

        DB::table('Topics')->insert($topics);

        //User::create(['email' => 'foo@bar.com']);
    }

}