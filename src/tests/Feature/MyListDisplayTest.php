<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Database\Seeders\StatusesTableSeeder;
use Database\Seeders\Payment_methodsTableSeeder;

class MyListDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(StatusesTableSeeder::class);
        $this->seed(Payment_methodsTableSeeder::class);
	}

     /** @test */
    public function liked_items_are_only_displayed_in_mylist_tab()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // 他ユーザーが出品し、自分がいいねした商品
        $otherUsersItem = Item::factory()->create(['user_id' => $otherUser->id]);
        $user->likedItems()->attach($otherUsersItem);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertSee($otherUsersItem->name);
    }

    /** @test */
    public function sold_label_is_displayed_for_purchased_items()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        // 他ユーザーが出品し、自分がいいねした商品
        $otherUsersItem = Item::factory()->create(['user_id' => $otherUser->id]);
        $user->likedItems()->attach($otherUsersItem);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $otherUsersItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('Sold');
    }

    /** @test */
    public function users_own_liked_items_are_not_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'My Own Liked Item',
        ]);

        $user->likedItems()->attach($ownItem->id);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('My Own Liked Item');
    }

    /** @test */
    public function unauthenticated_users_see_no_items_in_mylist_tab()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertDontSeeText('class="item-card"');
    }
}