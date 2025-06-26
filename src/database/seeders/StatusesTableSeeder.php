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
        Status::create(['id' => 1, 'name' => '良好']);
        Status::create(['id' => 2, 'name' => '目立った傷や汚れなし']);
        Status::create(['id' => 3, 'name' => 'やや傷や汚れあり']);
        Status::create(['id' => 4, 'name' => '状態が悪い']);
    }
}
