<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at'
    ];

    protected $fillable = [
        'number',
    ];

    // retorna produtos do grupo atual
    public function products()
    {
        return $this->hasMany(Product::class, 'group', 'id');
    }

    // método de callback para exclusão em cascata
    public static function boot()
    {
        parent::boot();

        self::deleting(function (Group $group) {
            // remove produtos
            $group->products()->delete();
        });
    }
}
