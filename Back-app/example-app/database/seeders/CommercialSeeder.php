<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommercialSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('commercials')->insert([
            [
                'name' => 'François Pignon',
                'phone_number' => '0123456789',
                'email' => 'francois.pignon@dinner.con',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juste Leblanc',
                'phone_number' => '987654312',
                'email' => 'juste.leblanc@dinner.con',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marlène Sassoeur',
                'phone_number' => '346789654',
                'email' => 'marlene.sassoeur@dinner.con',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
