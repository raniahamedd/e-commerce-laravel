<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes ; // SoftDeletes is a Global scope
    protected $fillable = [
        'name','parent_id','description','image','status','slug'
    ];
    // relation ship
    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }
    public function parent(){
        return $this->belongsTo(Category::class , 'parent_id' , 'id')->withDefault(['name'=> '_']);
    }
    public function children(){
        return $this->hasMany(Category::class , 'parent_id' , 'id');
    }

    // local scope

    public function scopeActive(Builder $builder){
        $builder->where('status','=','active');
    }

    public function scopeFilter(Builder $builder , $filter){

        $builder->when($filte['name'] ?? false , function(Builder $builder ,$value){
            $builder->where('name','LIKE',"%{$value}%");
        });

        $builder->when($filter['status'] ?? false,function(Builder $builder,$value){
            $builder->where('status','=',$value);
        });


        //built in scope in laravel like latest()  بيعملي ترتيب من الاحدث لاقدم
        // orderBy(,)

        // if( $filter['name'] ?? false){
        //     $builder->where('name','LIKE',"%{$filter['name']}%");
        // }
        // if($filter['status'] ?? false){
        //     $builder->where('status','=',$filter['status']);
        // }
    }
    public static function rules($id = 0){
        return [
            'name' => [
                'required',
                'string' ,
                'min:3' ,
                'max:255',
                "unique:categories,name,$id",
                new Filter(['laravel','php','admin']),
                ],
                //    Rule::unique('categories','name')->ignore($id);

            'parent_id' => ['nullable', 'int' , 'exists:categories,id' ],

            'image' => ['image' , 'mimes:png,jpg' , 'max:1048576' , 'dimensions:min_width=100,min_height=100'],

            'status' => ['required','in:active,archived']
        ];

    }
}
