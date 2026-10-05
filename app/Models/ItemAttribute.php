<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{
    use HasFactory, Translatable;

    protected $table = "item_attributes";
    protected $fillable = ['name', 'status'];
    protected $casts = [
        'id'     => 'integer',
        'name'   => 'string',
        'status' => 'integer',
    ];

    public function getNameAttribute(): ?string
    {
        return $this->getTranslation('name');
    }
}
