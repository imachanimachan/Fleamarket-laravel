<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\DatabaseSeeder;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(DatabaseSeeder::class);
	}

    public function test_comment_button_registers_comment_and_increments_comment_count_display()
    {
        $user = User::factory()->create();
		$this->actingAs($user);
        $item = Item::first();

        $response = $this->get(route('item.show', ['id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSeeText('0');

        $response = $this->post(route('item.comment', ['id' => $item->id]), [
            'comment' => 'コメントです。'
        ]);
        $response->assertRedirect();

        $response = $this->get(route('item.show', ['id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSeeText('1');

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'コメントです。',
        ]);
    }

    public function test_guest_cannot_post_comment()
    {
        $item = Item::first();

        $response = $this->post(route('item.comment', ['id' => $item->id]), [
            'comment' => 'コメントです。'
        ]);
        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => 'コメントです。',
        ]);
    }

    /** @test */
	public function validation_error_occurs_when_comment_is_empty()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
        $item = Item::first();

		$response = $this->post(route('item.comment', ['id' => $item->id]), [
			'comment' => '',
			'item_id' => $item->id,
		]);

		$response->assertSessionHasErrors(['comment']);
	}

    /** @test */
	public function validation_error_occurs_when_comment_exceeds_255_characters()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
        $item = Item::first();

		$longComment = str_repeat('あ', 256);

		$response = $this->post(route('item.comment', ['id' => $item->id]), [
			'comment' => $longComment,
			'item_id' => $item->id,
		]);

		$response->assertSessionHasErrors(['comment']);
	}
}
