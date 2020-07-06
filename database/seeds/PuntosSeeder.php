<?php

use Illuminate\Database\Seeder;


class PuntosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Cargo los puntos
        
        DB::table('puntos')->delete();
        
        DB::table('puntos')->insert(['coor_y' => 65, 'coor_x' => 33]);
        DB::table('puntos')->insert(['coor_y' => 65, 'coor_x' => 65]);
        DB::table('puntos')->insert(['coor_y' => 62, 'coor_x' => 106]);
        DB::table('puntos')->insert(['coor_y' => 34, 'coor_x' => 50]);
        DB::table('puntos')->insert(['coor_y' => 25, 'coor_x' => 120]);
        DB::table('puntos')->insert(['coor_y' => 10, 'coor_x' => 75]);
    }
}
