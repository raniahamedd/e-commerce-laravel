<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cart extends Model
{
    use HasFactory;
    public $increminting = false ;
    protected $fillable = [
       'cookie_id','user_id','product_id','quentity','optiens'
    ];
    public function user(){
        return $this->belongsTo(User::class , 'user_id','id')
                    ->withDefault(['name' => 'Anonymous']);
    }
    public function product(){
        return $this->belongsTo(Product::class , 'product_id','id');
    }

    // Events (Observers)
    // creating قبل عملية التخزين عالداتابيز , creaetd بعد عملية التخزين , updating ,updated ,saving ,saved
    // deleting ,deleted ,restoring , restored ,retrieved
    // creating لل كارت قبل عملية التخزين على الداتا بيز لذلك بستخدم ايفينت نوعها  id    مثلا بدي انشا ال
    //بصير بشكل افتراضي تتنفذ وراح يتم انشاء الاي دي بشكل تلقائي booted  هاي الدالة
    protected static function booted(){

    static::observe(CartObserver::class);


// Global scope for ->where('cookie_id','=',$this->getCookieId())
    static::addGlobalScope('cookie_id', function(Builder $builder){
        $builder->where('cookie_id','=', Cart::getCookieId()); // لذلك من الحلول انه اخلي المثود قيتكوكيايد نوعها ستاتيك واستدعيها بواسطة اسم المودل this ملاحظة انه في الستاتيك ميثود ما بقدر استخدم ال
        //CartModelRepository بتصير الفكرة انه لحاله بصير يعمل القلوبل سكوب قبل كل عملية بيتم اجرائها بال
        // كانه الموضوع صاير داينميك لانه انا فعليا كنت مستخدمة هاي الجملة في كا جملة استعلام فلما استخدمت القلوبل سكوب صار لحاله ينفذها مع كل جملة استعلام
    });
}

    public static function getCookieId(){
        $cookie_id = Cookie::get('cart_id');
        if(!$cookie_id){
            $cookie_id = Str::uuid(); // ازا مفش كوكي اي دي يعني مفش سلة مشتريات اعملي وحدة جديدة
        Cookie::queue('cart_id', $cookie_id , 30 * 24 * 60); //Cookie Expired
        //   Cookie::queue بتعتمد على الميدل وير
        }
        return $cookie_id;
    }

}
