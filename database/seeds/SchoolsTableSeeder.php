<?php

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['ACS', 'Hwa Chong', 'SJI', 'SMU', 'AJC', 'VJC', 'SJC', 'ACJC', 'ACSI', 'Raffles'];
        DB::table('schools')->insert([
            'name' => $names[array_rand($names)],
            'about' => 'Lorem ipsum dolor.',
            'address' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'principal' => 'Mrs. Ho',
            'num_students' => rand(500, 1500),
            'contact_number' => '8556 4546',
            'link' => 'www.school.com'
        ]);
    }
}
