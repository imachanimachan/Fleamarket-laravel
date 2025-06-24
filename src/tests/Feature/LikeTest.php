<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Database\Seeders\DatabaseSeeder;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(DatabaseSeeder::class);
	}

    public function test_like_button_registers_like_and_increments_like_count_display()
    {
        $user = User::factory()->create();
		$this->actingAs($user);
        $item = Item::first();

        $response = $this->get(route('item.show', ['id' => $item->id]));

        $response->assertStatus(200);
        $response->assertSeeText('0');

        $response = $this->post(route('item.like', ['id' => $item->id]));
        $response->assertRedirect();

        $response = $this->get(route('item.show', ['id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSeeText('1');

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_liked_icon_changes_appearance_when_liked()
    {
        $user = User::factory()->create();
		$this->actingAs($user);
        $item = Item::first();

        $response = $this->get(route('item.show', ['id' => $item->id]));

        $response->assertStatus(200);
        $response->assertDontSee('item-detail__icon-mark--active');

        $response = $this->post(route('item.like', ['id' => $item->id]));
        $response->assertRedirect();

        $response = $this->get(route('item.show', ['id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSee('item-detail__icon-mark--active');
    }

    public function test_like_can_be_removed_and_like_count_decreases()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::first();

        $response = $this->post(route('item.like', ['id' => $item->id]));
        $response->assertRedirect();

        $response = $this->get(route('item.show', ['id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSeeText('1');

        $response = $this->post(route('item.like', ['id' => $item->id]));
        $response->assertRedirect();

        $response = $this->get(route('item.show', ['id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSeeText('0');

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
