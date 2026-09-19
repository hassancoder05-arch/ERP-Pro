<?php

namespace App\Models;
use App\Models\SaleItem;
use App\Models\InventoryTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'name',
        'category',
        'brand',
        'description',
        'purchase_price',
        'selling_price',
        'stock',
        'minimum_stock',
        'status',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock' => 'integer',
        'minimum_stock' => 'integer',
    ];
    public function inventoryTransactions()
{
    return $this->hasMany(InventoryTransaction::class);
}
public function saleItems()
{
    return $this->hasMany(SaleItem::class);
}
}