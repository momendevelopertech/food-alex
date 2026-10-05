<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingMenu extends Model
{
    use HasFactory;

    protected $table = 'setting_menus';

    protected $fillable = [
        'name',
        'language',
        'url',
        'icon',
        'priority',
        'status',
        'addon',
    ];

    protected $casts = [
        'id'       => 'integer',
        'priority' => 'integer',
        'status'   => 'integer',
        'addon'    => 'integer',
    ];
}
