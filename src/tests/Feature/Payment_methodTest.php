<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\DatabaseSeeder;

class Payment_methodTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(DatabaseSeeder::class);
	}

    /** @test */
    public function selected_payment_method_is_reflected()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::first();

        $response = $this->get(route('item.purchase', ['id' => $item->id, 'payment_method' => 'convenience']));

        $response->assertStatus(200);
        $response->assertSee('コンビニ払い');
    }
}
