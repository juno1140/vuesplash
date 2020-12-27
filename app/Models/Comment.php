<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /** JSONに含める属性 */
    protected $visible = [
        'author', 'content',
    ];

    /**
     * リレーションシップ - usersテーブル
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }
}
