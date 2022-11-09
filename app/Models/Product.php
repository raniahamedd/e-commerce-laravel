<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','dsecription','image','category_id','store_id',
        'compare_price','price','status'
    ];

    // GLOBAL SCOPE
    protected static function booted(){
        static::addGlobalScope('store', new StoreScope() );
    }
    
    public function category(){
        return $this->belongsTo(Category::class , 'category_id', 'id');
    }
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,
        // لو انا مش ملتزم بالتسمية راح احتاج براميتر تانيين والي همل تحت اما لو ملتزم بالتسمية بكتفي فقط باسم المودل التاني
        // 'product_tag' اسم الجدول الي فيه العلاقة pivot table
        // 'product_id' //FK in pivot table for the current table
        // 'tag_id //FK in pivot table for the related table
        // 'id', //PK for the current table
        // 'id', //PK for the related table
    );
    }
    public function scopeActive(Builder $builder){
        return $builder->where('status','=','active');
    }
    // Accessors
    public function getImageUrlAttribute()
    {
        if(!$this->image){
            return 'https://secureservercdn.net/50.62.89.79/l6p.ee1.myftpupload.com/wp-content/uploads/2021/02/default-product-image-2.png?time=1661982045' ;
        }
        if(Str::startsWith($this->image, ['http://','https://'])) {
            return $this->image; ;
        }
        return asset('storage/'. $this->image);
    }
    public function getSalePercentAttribute()
    {
       if(!$this->compare_price){
        return 0;
       }
       return round(100 - (100 * ($this->price / $this->compare_price)),1);
    }
}
