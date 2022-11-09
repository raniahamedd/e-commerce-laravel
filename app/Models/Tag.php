<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable =['name','slug'];
    //لازم اعرفله بشكل صريح هنا  timestamp  بما انه شلنا ال 

    public $timestamps = false ;

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
