<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CreateShapesSeeder::class);
         $this->call(CreateColorTypeSeeder::class);
         $this->call(InitSiteOptionsSeeder::class);
         $this->call(WheelHardnessSeeder::class);
    }
}
