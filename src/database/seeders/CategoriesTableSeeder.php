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
        Category::create(['id' => 1, 'name' => 'ファッション']);
        Category::create(['id' => 2, 'name' => '家電']);
        Category::create(['id' => 3, 'name' => 'インテリア']);
        Category::create(['id' => 4, 'name' => 'レディース']);
        Category::create(['id' => 5, 'name' => 'メンズ']);
        Category::create(['id' => 6, 'name' => 'コスメ']);
        Category::create(['id' => 7, 'name' => '本']);
        Category::create(['id' => 8, 'name' => 'ゲーム']);
        Category::create(['id' => 9, 'name' => 'スポーツ']);
        Category::create(['id' => 10, 'name' => 'キッチン']);
        Category::create(['id' => 11, 'name' => 'ハンドメイド']);
        Category::create(['id' => 12, 'name' => 'アクセサリー']);
        Category::create(['id' => 13, 'name' => 'おもちゃ']);
        Category::create(['id' => 14, 'name' => 'ベビー・キッズ']);
    }
}