<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhotoListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_正しい構造のJSONを返却する()
    {
        Photo::factory()->count(5)->create();

        $response = $this->json('GET', route('photo.index'));

        // 生成した写真データを作成日降順で取得
        $photos = Photo::with(['owner'])->orderBy('created_at', 'desc')->get();

        $expected_data = $photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'url' => $photo->url,
                'owner' => [
                    'name' => $photo->owner->name,
                ],
                'liked_by_user' => false,
                'likes_count' => 0,
            ];
        })->all();

        $response->assertStatus(200)
            // レスポンスJSONのdata項目に含まれる要素が5つであること
            ->assertJsonCount(5, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
}
