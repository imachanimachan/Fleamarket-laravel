<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Database\Seeders\StatusesTableSeeder;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(StatusesTableSeeder::class);
	}

	public function test_search_items_by_partial_name()
	{
		$user = User::factory()->create();
		$this->actingAs($user);

        $otherUser = User::factory()->create();
        $notebook = Item::factory()->create(['name' => 'Notebook', 'user_id' => $otherUser->id]);
        $pen = Item::factory()->create(['name' => 'Pen', 'user_id' => $otherUser->id]);

		$responseRecommend = $this->get('/?tab=recommend&keyword=note');

		$responseRecommend->assertStatus(200);
		$responseRecommend->assertSee('Notebook');
		$responseRecommend->assertDontSee('Pen');
	}

    public function test_search_and_move_to_mylist_keeps_keyword()
	{
		$user = User::factory()->create();
		$this->actingAs($user);

        $otherUser = User::factory()->create();
        $notebook = Item::factory()->create(['name' => 'Notebook', 'user_id' => $otherUser->id]);
        $pen = Item::factory()->create(['name' => 'Pen', 'user_id' => $otherUser->id]);

        Like::create(['user_id' => $user->id, 'item_id' => $notebook->id]);
		Like::create(['user_id' => $user->id, 'item_id' => $pen->id]);

		$responseRecommend = $this->get('/?tab=recommend&keyword=note');

		$responseRecommend->assertStatus(200);
		$responseRecommend->assertSee('Notebook');
		$responseRecommend->assertDontSee('Pen');

		$responseMyList = $this->get('/?tab=mylist&keyword=note');

		$responseMyList->assertStatus(200);
		$responseMyList->assertSee('Notebook');
		$responseMyList->assertDontSee('Pen');

		$responseMyList->assertSee('value="note"', false);
	}
}
