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
        $user1 = User::factory()->create([
            'name' => 'User One',
            'image_path' => '8syhhy13VwPlOmfSwLBh7MxU1iEhLlkv7UOt5Umc.png',
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
        ]);

        $user2 = User::factory()->create([
            'name' => 'User Two',
            'image_path' => 'bIbso8sXVqBDHG25UNICUnrsLo7vnO1hQd5BK5in.jpg',
            'email' => 'user2@example.com',
            'password' => bcrypt('password123'),

        ]);

        $user3 = User::factory()->create([
            'name' => 'User Three',
            'image_path' => 'Zl62KsNuQPg3GFUoms8SzVMMDSxXHyqN1UczgUUg.png',
            'email' => 'user3@example.com',
            'password' => bcrypt('password123'),

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
