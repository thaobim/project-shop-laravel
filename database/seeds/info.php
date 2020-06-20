<?php

use Illuminate\Database\Seeder;

class info extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('info')->delete();
        DB::table('info')->insert([
            ['id'=>1,'user_id'=>2,],
            ['id'=>2,'user_id'=>1,]
        ]);
    }
}
