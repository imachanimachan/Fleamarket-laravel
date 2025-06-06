<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class Payment_methodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ["コンビニ支払い", "カード支払い"];

        foreach ($names as $name) {
            PaymentMethod::create(['name' => $name]);
        }
    }
}
