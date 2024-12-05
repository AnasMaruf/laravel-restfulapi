<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPriceFormattedAttribute(){
        return formatRupiah($this->price);
    }

    public function getApiResponseAttribute(){
        return [
            'id' => $this->id,
            'image' => $this->image_url,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'price_formatted' => $this->price_formatted
        ];
    }


    public function getImageUrlAttribute(){
        if (is_null($this->image)) {
            return null;
        }
        return asset('storage/'.$this->image);
    }
}
