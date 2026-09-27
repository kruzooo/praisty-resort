<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'reference',
    'guest_name',
    'guest_email',
    'phone',
    'country',
    'room_slug',
    'room_name',
    'check_in',
    'check_out',
    'guests',
    'nights',
    'stay_total',
    'resort_fee',
    'taxes',
    'grand_total',
    'payment_method',
    'status',
])]
class Reservation extends Model
{
    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'guests' => 'integer',
            'nights' => 'integer',
            'stay_total' => 'integer',
            'resort_fee' => 'integer',
            'taxes' => 'integer',
            'grand_total' => 'integer',
        ];
    }
}
