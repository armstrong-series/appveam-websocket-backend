<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasUuids, HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable  = [
        'id',
        'user_id',
        'status',
        'currency',
        'meta',
        'amount',
        'customer_id',
        'transaction_refrence'
    ];

    protected $casts = [
        'meta' => 'array',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
