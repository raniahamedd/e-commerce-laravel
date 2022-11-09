<?php
//  DataBase Repository  راح يكون عندي مصدر الداتا هيا ال
namespace app\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Cart\CartRepository;

class CartModelRepository implements CartRepository
{
    // collect function بستخدمها عشان احول اري ل كوليكشن
    // الكوليكشن عبارة عن اوبجيكت بلارفيل بيشبه الاري لحد بعيد
    protected $items;

    public function __construct()
    {
        $this->items = collect([]) ;
    }
    public function get() : Collection{

        if(!$this->items->count()){
            $this->items = Cart::with('Product')->get();
        }
        return $this->items;

        // return Cart::with('product')->get(); بدل ما كل مرة اطلب البرودكت من الداتا بيز انا بجيبهم مرة وحدة بريكويست واحد وبخزنهم عندي وبستخدمهم وين م بدي
        // where('cookie_id','=',$this->getCookieId()) مشان الجملة هاي في كل جملة عمال بنكررها فكرنا نعمل قلوبل سكوب
    }


    public function add(Product $product , $quentity = 1){
        $item = Cart::where('product_id','=',$product->id)
                    ->first();
        if(!$item){
          $cart =  Cart::create([
                    // 'cookie_id' => $this->getCookieId(), بدي اعملها ك ايفنت عمستوى الاوبسيرفير الموجود بالبووتيد بمودل الكارد
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quentity' => $quentity,
                ]);
           $this->get()->push($cart);
            }
        return $item->increment('quentity',$quentity);
    }


    public function update($id, $quentity)
    {
        Cart::where('id','=',$id)->update(['quentity' => $quentity]);
    }


    public function delete($id)
    {
        Cart::where('id','=',$id)->delete();
    }


    public function empty()
    {
        Cart::query()->destroy();
        // query() methode كويري بترجعلي البيلدير تبع المودل
    }


    public function total() : float
    {
        /* return (float) Cart::join('products','products.id','=','carts.product_id')
                    ->selectRaw('SUM(products.price * carts.quentity) AS total')
                    ->value('total'); */
        return $this->get()->sum(function ($item){ // حتمرر الايتم الي بلف عليه
                   return ( $item->quentity * $item->product->price );
        });
    }


}
