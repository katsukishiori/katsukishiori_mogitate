<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSeason extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_season';
    protected $fillable = ['product_id', 'season_id'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
