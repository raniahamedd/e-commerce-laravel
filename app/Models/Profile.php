<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id' ; //لازم اكتبها بشكل صريح طالما غيرت الاي دي الافتراضي
    protected $fillable = [
        'user_id','first_name','last_name', 'birthday', 'gender',
        'city','state','country','street_address','postal_code',
        'local'
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' ,'id');
    }
}
