<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Item;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(StatusesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(Payment_methodsTableSeeder::class);


        $itemCategoryMap = [
            '腕時計' => ['ファッション', 'メンズ'],
            'HDD' => ['家電'],
            '革靴' => ['ファッション', 'メンズ'],
            'ノートPC' => ['家電'],
            'ショルダーバッグ' => ['ファッション', 'レディース'],
            'タンブラー' => ['キッチン'],
            'コーヒーミル' => ['キッチン'],
            'メイクセット' => ['コスメ']
        ];

        foreach ($itemCategoryMap as $itemName => $categoriesNames) {
            $item = Item::where('name', $itemName)->first();
            $categoryIds = Category::whereIn('name', $categoriesNames)->pluck('id')->toArray();

            $item->categories()->sync($categoryIds);
        }
    }
}
