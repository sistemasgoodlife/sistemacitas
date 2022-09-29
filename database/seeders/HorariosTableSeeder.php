<?php

namespace Database\Seeders;

use App\Models\Horarios;
use Illuminate\Database\Seeder;

class HorariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<7; ++$i){
            Horarios::create([
                'day' => $i,
                'active' => ($i==0),
                'morning_start' => ($i==0 ? '08:00:00' : '07:00:00'),
                'morning_end' => ($i==0 ? '10:00:00' : '07:00:00'),
                'afternoon_start' => ($i==0 ? '15:00:00' : '14:00:00'),
                'afternoon_end' => ($i==0 ? '17:00:00' : '14:00:00'),
                'user_id' => 3
            ]);
        }
    }
}
