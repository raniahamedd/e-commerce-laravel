<?php

namespace App\Repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function get() : Collection;

    public function add(Product $product , $quentity = 1);

    public function update($id,$quentity);

    public function delete($id); // حذف منتج داخل السلة

    public function empty(); // حذف كل محتوى السلة

    public function total();
}
