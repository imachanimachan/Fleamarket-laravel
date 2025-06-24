<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Database\Seeders\StatusesTableSeeder;
use Database\Seeders\Payment_methodsTableSeeder;


class ItemListDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(StatusesTableSeeder::class);
        $this->seed(Payment_methodsTableSeeder::class);
	}

    public function test_all_items_are_displayed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $otherUser = User::factory()->create();
        $visibleItems = Item::factory()->count(10)->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->get('/?tab=recommend');

        foreach ($visibleItems as $item) {
            $response->assertSee($item->name);
        }
    }

        /** @test */
    public function sold_label_is_displayed_for_purchased_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $otherUser = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $otherUser->id]);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/?tab=recommend');

        $response->assertSee('Sold');
    }

    /** @test */
    public function logged_in_users_own_items_are_not_displayed()
    {
        $user = User::factory()->create();
		$this->actingAs($user);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'My Product',
        ]);

        $response = $this->get('/?tab=recommend');

        $response->assertDontSee('My Product');
    }
}
