<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use Translatable;

    protected $table = "taxes";
    protected $fillable = ['name', 'code', 'tax_rate', 'type', 'status'];
    protected $casts = [
        'id'       => 'integer',
        'name'     => 'string',
        'code'     => 'string',
        'tax_rate' => 'string',
        'type'     => 'integer',
        'status'   => 'integer',
    ];

    public function getNameAttribute(): ?string
    {
        return $this->getTranslation('name');
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Item::class)->where(['status' => Status::ACTIVE]);
    }
}