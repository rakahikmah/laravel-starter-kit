<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'menu_id',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role')->withTimestamps();;
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
