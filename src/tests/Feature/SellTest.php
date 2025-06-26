<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\StatusesTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellTest extends TestCase
{
        use RefreshDatabase;

        public function setUp(): void
        {
            parent::setUp();

            $this->seed(StatusesTableSeeder::class);
            $this->seed(CategoriesTableSeeder::class);
        }

        public function test_required_item_information_can_be_saved()
        {
            $user = User::factory()->create();
            $this->actingAs($user);

            Storage::fake('public');
            $image = UploadedFile::fake()->image('dummy.jpeg');

            $response = $this->post('/sell',[
            'image_path' => $image,
            'categories' => [1,2],
            'status_id' => 1,
            'brand' => 'ブランド',
            'name' => 'テスト商品',
            'description' => '説明',
            'price' => 5000,
            ]);

            Storage::disk('public')->assertExists('items/' . $image->hashName());

            $this->assertDatabaseHas('items', [
                'user_id' => $user->id,
                'image_path' => $image->hashName(),
                'status_id' => 1,
                'brand' => 'ブランド',
                'name' => 'テスト商品',
                'description' => '説明',
                'price' => 5000,
            ]);

            $item = Item::where('name', 'テスト商品')->first();

            $this->assertTrue($item->categories->pluck('id')->contains(1));
            $this->assertTrue($item->categories->pluck('id')->contains(2));
        }
    }
