<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Status;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = Status::pluck('id', 'name');

        $items = [

            [
                'name' => '腕時計',
                'price' => 15000,
                'image_path' => 'Armani+Mens+Clock.jpg',
                'color' => null,
                'brand' => null,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'status_id' => $statuses['良好'],
                'user_id' => '1',

            ],

            [
                'name' => 'HDD',
                'price' => 5000,
                'image_path' => 'HDD+Hard+Disk.jpg',
                'color' => null,
                'brand' => null,
                'description' => '高速で信頼性の高いハードディスク',
                'status_id' => $statuses['目立った傷や汚れなし'],
                'user_id' => '1',
            ],

            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'image_path' => 'iLoveIMG+d.jpg',
                'color' => null,
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'status_id' => $statuses['やや傷や汚れあり'],
                'user_id' => '1',
            ],

            [
                'name' => '革靴',
                'price' => 4000,
                'image_path' => 'Leather+Shoes+Product+Photo.jpg',
                'color' => null,
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'status_id' => $statuses['状態が悪い'],
                'user_id' => '1',
            ],

            [
                'name' => 'ノートPC',
                'price' => 45000,
                'image_path' => 'Living+Room+Laptop.jpg',
                'color' => null,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'status_id' => $statuses['良好'],
                'user_id' => '1',
            ],

            [
                'name' => 'マイク',
                'price' => 8000,
                'image_path' => 'Music+Mic+4632231.jpg',
                'color' => null,
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'status_id' => $statuses['目立った傷や汚れなし'],
                'user_id' => '1',
            ],

            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'image_path' => 'Purse+fashion+pocket.jpg',
                'color' => null,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'status_id' => $statuses['やや傷や汚れあり'],
                'user_id' => '1',
            ],

            [
                'name' => 'タンブラー',
                'price' => 500,
                'image_path' => 'Tumbler+souvenir.jpg',
                'color' => null,
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'status_id' => $statuses['状態が悪い'],
                'user_id' => '1',
            ],

            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'image_path' => 'Waitress+with+Coffee+Grinder.jpg',
                'color' => null,
                'brand' => null,
                'description' => '手動のコーヒーミル',
                'status_id' => $statuses['良好'],
                'user_id' => '1',
            ],

            [
                'name' => 'メイクセット',
                'price' => 2500,
                'image_path' => '外出メイクアップセット.jpg',
                'color' => null,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'status_id' => $statuses['目立った傷や汚れなし'],
                'user_id' => '1',
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
