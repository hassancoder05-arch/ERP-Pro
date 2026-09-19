<?php

namespace App\Models;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'address',
        'credit_limit',
        'opening_balance',
        'status',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'opening_balance' => 'decimal:2',
    ];
    public function sales()
{
    return $this->hasMany(Sale::class);
}
}