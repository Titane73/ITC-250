<?php

/**
 * Cart class, tracks quantity and price of items in an online shopping cart.
 *
 * @author Sam McHaney
 */
class Cart {
    
    public $SALES_TAX = 0.095;
    
    public function __construct(){
        
    }
    
    /*
     *  Returns subtotal (untaxed) for items in the cart.
     */
    public function getSubtotal($itm_array){
        $subTotal = 0.0;
            foreach ($itm_array as $item){
                $subTotal += ($item->price * $item->quantity);
            }
        return $subTotal;
    }
    
    /*
     *  Returns total tax for items in cart if items are in the cart, or else
     * returns 0.
     */
    public function getTax($itm_array){
        $tax = ($this->getSubtotal($itm_array) * $this->SALES_TAX);
        return $tax;
    }
    
    /*
     *  Returns total price for items in cart if not empty, else returns 0.
     */
    public function getTotal($itm_array){
        $total = ($this->getTax($itm_array) + $this->getSubtotal($itm_array));
        return $total;
    }
    
}
