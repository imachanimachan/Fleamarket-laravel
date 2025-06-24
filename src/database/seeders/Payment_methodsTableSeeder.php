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
        PaymentMethod::create([
            'id' => 1,
            'name' => 'コンビニ支払い'
        ]);

        PaymentMethod::create([
            'id' => 2,
            'name' => 'カード支払い'
        ]);
    }
}
