<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'reviewer_id',
        'reviewed_user_id',
        'rating',
    ];

    /**
     * レビューした人
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * レビューされた人
     */
    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }

    /**
     * 対象の商品
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
