<?php

namespace App;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @mixin Eloquent
 */

class Category extends Model
{
    protected $table = 'tbl_category';
    protected $primaryKey = 'categoryNumber';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function parent() {
        return $this->hasOne(Category::class, 'categoryNumber', 'categoryParent');
    }

    public function children() {
        return $this->hasMany(Category::class, 'categoryParent','categoryNumber');
    }

    public function allChildren() {
        return $this->hasMany(Category::class, 'categoryParent','categoryNumber')
            ->with('children');
    }
}


