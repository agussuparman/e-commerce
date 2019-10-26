<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'parent_id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->products()->detach();
            
            foreach ($model->childs as $child) {
                $child->parent_id = '';
                $child->save();
            }
        });
    }

    public function childs()
    {
    	return $this->hasMany('App\Category', 'parent_id');
    }

    public function parent()
    {
    	return $this->belongsTo('App\Category', 'parent_id');
    }

    public function products()
    {
    	return $this->belongsToMany('App\Product');
    }

    public function scopeNoParent($query)
    {
        return $this->where('parent_id', '');
    }

    public function getRelatedProductsIdAttribute()
    {
        $result = $this->products->lists('id')->toArray();
        foreach ($this->childs as $child) {
            $result = array_merge($result, $child->related_products_id);
        }
        return $result;
    }

    public function getTotalProductsAttribute()
    {
        return Product::whereIn('id', $this->related_products_id)->count();
    }

    public function hasParent()
    {
        return $this->parent_id > 0;
    }

    public function hasChild()
    {
        return $this->childs()->count() > 0;
    }
}
