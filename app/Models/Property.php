<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Psy\Util\Str;

class Property extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'description',
        'surface',
        'rooms',
        'bedrooms',
        'floor',
        'price',
        'city',
        'address',
        'postal_code',
        'sold'
    ];

    public function options(): BelongsToMany {
        return $this->belongsToMany(Option::class);
    }

    public function getSlug(): string {
        return \Illuminate\Support\Str::slug($this->title);
    }
}
