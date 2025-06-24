<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Status;
use App\Models\Comment;
use App\Models\Like;
use Database\Seeders\StatusesTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
;

class ItemDetailDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
	{
		parent::setUp();

		$this->seed(StatusesTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
	}

    public function test_item_detail_page_displays_all_required_information()
	{
		$user = User::factory()->create(['image_path' => 'user.jpg']);
		$itemOwner = User::factory()->create();

		$item = Item::factory()->create([
			'name' => 'テスト商品',
			'brand' => 'ブランド名',
			'price' => 12345,
			'description' => 'これは説明です。',
			'user_id' => $itemOwner->id,
			'status_id' => 1,
			'image_path' => 'item.jpg',
		]);

        $category1 = Category::where('name', 'ファッション')->first();
        $category2 = Category::where('name', '家電')->first();
        $item->categories()->attach([$category1->id, $category2->id]);

		Comment::create([
			'user_id' => $user->id,
			'item_id' => $item->id,
			'comment' => 'これはコメントです。',
		]);

		Like::create([
			'user_id' => $user->id,
			'item_id' => $item->id,
		]);

		$this->actingAs($user);

		$response = $this->get(route('item.show', ['id' => $item->id]));

		$response->assertStatus(200);
		$response->assertSee('テスト商品');
		$response->assertSee('ブランド名');
		$response->assertSee('¥12,345');
		$response->assertSee('これは説明です。');
		$response->assertSee('良好');
        // ✅ 複数カテゴリが表示されているか
		$response->assertSee('ファッション');
		$response->assertSee('家電');

		$response->assertSee('これはコメントです。');
		$response->assertSee($user->name);
        $response->assertSeeText((string) $item->likes_count);
        $response->assertSeeText((string) $item->comments_count);
        $response->assertSee('storage/items/item.jpg');
		$response->assertSee('storage/users/user.jpg');
    }
}
