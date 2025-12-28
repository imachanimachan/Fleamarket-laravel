<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Status;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = Status::pluck('id', 'name');
        $user1 = User::where('email', 'user1@example.com')->firstOrFail();
        $user2 = User::where('email', 'user2@example.com')->firstOrFail();
        $items = [

            [
                'name' => '腕時計',
                'price' => 15000,
                'image_path' => 'Armani+Mens+Clock.jpg',
                'brand' => null,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'status_id' => $statuses['良好'],
                'user_id' => $user1->id,

            ],

            [
                'name' => 'HDD',
                'price' => 5000,
                'image_path' => 'HDD+Hard+Disk.jpg',
                'brand' => null,
                'description' => '高速で信頼性の高いハードディスク',
                'status_id' => $statuses['目立った傷や汚れなし'],
                'user_id' => $user1->id,
            ],

            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'image_path' => 'iLoveIMG+d.jpg',
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'status_id' => $statuses['やや傷や汚れあり'],
                'user_id' => $user1->id,
            ],

            [
                'name' => '革靴',
                'price' => 4000,
                'image_path' => 'Leather+Shoes+Product+Photo.jpg',
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'status_id' => $statuses['状態が悪い'],
                'user_id' => $user1->id,
            ],

            [
                'name' => 'ノートPC',
                'price' => 45000,
                'image_path' => 'Living+Room+Laptop.jpg',
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'status_id' => $statuses['良好'],
                'user_id' => $user1->id,
            ],

            [
                'name' => 'マイク',
                'price' => 8000,
                'image_path' => 'Music+Mic+4632231.jpg',
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'status_id' => $statuses['目立った傷や汚れなし'],
                'user_id' => $user2->id,
            ],

            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'image_path' => 'Purse+fashion+pocket.jpg',
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'status_id' => $statuses['やや傷や汚れあり'],
                'user_id' => $user2->id,
            ],

            [
                'name' => 'タンブラー',
                'price' => 500,
                'image_path' => 'Tumbler+souvenir.jpg',
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'status_id' => $statuses['状態が悪い'],
                'user_id' => $user2->id,
            ],

            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'image_path' => 'Waitress+with+Coffee+Grinder.jpg',
                'brand' => null,
                'description' => '手動のコーヒーミル',
                'status_id' => $statuses['良好'],
                'user_id' => $user2->id,
            ],

            [
                'name' => 'メイクセット',
                'price' => 2500,
                'image_path' => '外出メイクアップセット.jpg',
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'status_id' => $statuses['目立った傷や汚れなし'],
                'user_id' => $user2->id,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
