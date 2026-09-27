<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'reservation_id',
    'reference',
    'name',
    'email',
    'rating',
    'message',
])]
class CustomerFeedback extends Model
{
    protected $table = 'customer_feedback';

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }
}
