<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Mockery;
use Stripe\Checkout\Session;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(DatabaseSeeder::class);
	}

    /** @test */
	public function purchase_button_creates_order_record_successfully()
	{
        $mock = Mockery::mock('alias:' . Session::class);
        $mock->shouldReceive('create')
            ->once()
            ->andReturn((object)['url' => '/dummy-checkout']);

        $user = User::factory()->create([
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
        ]);
        $this->actingAs($user);
        $item = Item::first();

		$response = $this->post(route('stripe.session', ['id' => $item->id]), [
			'payment_method' => 'card',
            'item_id' => $item->id,
		]);

		$response->assertRedirect();

		$this->assertDatabaseHas('orders', [
			'user_id' => $user->id,
			'item_id' => $item->id,
			'payment_method_id' => 2,
		]);
	}

    /** @test */
    public function purchased_item_is_displayed_as_sold_on_item_list()
    {
        $mock = Mockery::mock('alias:' . Session::class);
        $mock->shouldReceive('create')
            ->once()
            ->andReturn((object)['url' => '/dummy-checkout']);

        $user = User::factory()->create([
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
        ]);
        $this->actingAs($user);
        $item = Item::first();

        $response = $this->post(route('stripe.session', ['id' => $item->id]), [
            'payment_method' => 'convenience',
            'item_id' => $item->id,
        ]);

        $response->assertRedirect();

        $response = $this->get('/?tab=recommend');

        $response->assertStatus(200);
        $response->assertSee('sold');
    }

    /** @test */
    public function purchased_item_appears_in_user_purchase_list()
    {
        $mock = Mockery::mock('alias:' . Session::class);
        $mock->shouldReceive('create')
            ->once()
            ->andReturn((object)['url' => '/dummy-checkout']);

        $user = User::factory()->create([
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
        ]);
        $this->actingAs($user);
        $item = Item::first();

        $response = $this->post(route('stripe.session', ['id' => $item->id]), [
            'payment_method' => 'convenience',
            'item_id' => $item->id,
        ]);

        $response->assertRedirect();

        $response = $this->get('/mypage?tab=buy');

        $response->assertStatus(200);
        $response->assertSee($item->name);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

}