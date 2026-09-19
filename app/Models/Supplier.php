<?php

namespace App\Models;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_id',
        'name',
        'company_name',
        'email',
        'phone',
        'address',
        'opening_balance',
        'status',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
    ];
    

public function payments()
{
    return $this->hasMany(Payment::class);
}
}