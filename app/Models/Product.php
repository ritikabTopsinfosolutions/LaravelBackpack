<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        "name",
        "sku",
        "image",
        "description",
        "price",
        "category_id",
        "product_type",
        "in_stock",
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getInStockAttribute($value){
        return $value == 0 ? 'No' : 'Yes';
    }

    public function setInStockAttribute($value)
    {
        $this->attributes['in_stock'] = $value == 'Yes' ? 1 : 0;
    }
}
