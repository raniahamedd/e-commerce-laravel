<?php

namespace App\View\Components;

use App\Repositories\Cart\CartRepository;
use Illuminate\View\Component;

class CartMenu extends Component
{
    public $items ;
    public $total ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CartRepository $cart)
    {
        $this->items = $cart->get(); // it will return collection
        $this->total = $cart->total();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu');
    }
}
