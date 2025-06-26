<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(DatabaseSeeder::class);
	}

    public function test_required_profile_information_is_displayed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'image_path' => 'selldummy.jpg',
        ]);

        $seller = User::factory()->create();
        $buyItem = Item::factory()->create([
            'user_id' => $seller->id,
            'image_path' => 'buydummy.jpg',
        ]);

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
        ]);

        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertSeeText($user->name);
        $response->assertSeeText($user->image_path);

        $response = $this->get('/mypage?tab=sell');
        $response->assertStatus(200);
        $response->assertSeeText($sellItem->name);
        $response->assertSee('selldummy.jpg');

        $response = $this->get('/mypage?tab=buy');
        $response->assertStatus(200);
        $response->assertSeeText($buyItem->name);
        $response->assertSee('buydummy.jpg');
    }

    public function test_profile_page_displays_default_user_information()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'image_path' => 'dummy.jpg',
            'postcode' => '123-4567',
            'address' => '東京都渋谷区123',
            'building' => 'アパート',
        ]);
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('dummy.jpg');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区123');
        $response->assertSee('アパート');
    }

}
