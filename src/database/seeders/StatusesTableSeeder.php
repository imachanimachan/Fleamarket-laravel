<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ["良好", "目立った傷や汚れなし", "やや傷や汚れあり", "状態が悪い"];

        foreach ($names as $name) {
            Status::create(['name' => $name]);
        }
    }
}
