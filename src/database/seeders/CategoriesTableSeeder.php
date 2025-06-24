<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ["ファッション", "家電", "インテリア", "レディース", "メンズ", "コスメ", "本", "ゲーム", "スポーツ", "キッチン", "ハンドメイド", "アクセサリー", "おもちゃ","ベビー・キッズ"];

        foreach ($names as $name) {
            Category::create(['name' => $name]);
        }
    }
}