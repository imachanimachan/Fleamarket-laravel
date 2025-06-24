<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Database\Seeders\DatabaseSeeder;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(DatabaseSeeder::class);
	}

    /** @test */
    public function updated_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::first();

        $response = $this->get(route('address.purchase', ['id' => $item->id]));
        $response->assertStatus(200);

        $response = $this->patch(route('update.address', ['id' => $item->id]), [
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => 'アパート',
        ]);
        $response->assertStatus(200);
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-2-3');
        $response->assertSee('アパート');
    }

    /** @test */
    public function shipping_address_is_correctly_linked_to_purchased_order()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::first();

        $response = $this->get(route('address.purchase', ['id' => $item->id]));
        $response->assertStatus(200);

        $response = $this->patch(route('update.address', ['id' => $item->id]), [
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => 'アパート',
        ]);
        $response->assertStatus(200);

        $this->actingAs($user->fresh());

        $response = $this->get(route('item.purchase', ['id' => $item->id, 'payment_method' => 'convenience']));
        $response->assertStatus(200);
        $response->assertSee('コンビニ払い');

        $response = $this->post(route('stripe.session', ['id' => $item->id]), [
            'item_id' => $item->id,
            'payment_method' => 'convenience',
        ]);

        $response->assertRedirect();

        $order = Order::where('user_id', $user->id)->where('item_id', $item->id)->first();
        $this->assertNotNull($order);

        $updatedUser = User::find($user->id);
        $this->assertEquals('123-4567', $updatedUser->postcode);
        $this->assertEquals('東京都渋谷区1-2-3', $updatedUser->address);
        $this->assertEquals('アパート', $updatedUser->building);
    }
}
