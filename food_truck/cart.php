<?php

/*
 * @package SurveySez
 * @author Kyrrah Nork <kyrrahnork@gmail.com>
 * @author Nicole Brown <giantspork@gmail.com>
 * @author Ron Hamasaki <shinobu.kinjo@gmail.com>
 * @version 0.1 2017/07/17
 * @link http://kyrrahnork.com/sm17
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see menu.php
 * @see index.php 
 * @todo none
*/


class Cart {
    
    public $SALES_TAX = 0.095;
    
    public function __construct(){
        
    }
    
    
      #Returns pre-tax subtotal for cart items.
     
    public function getSubtotal($itm_array){
        $subTotal = 0.0;
            foreach ($itm_array as $item){
                $subTotal += ($item->price * $item->quantity);
            }
        return $subTotal;
    }
    
    
      #If items in cart, return tax total, else return 0.
     
    public function getTax($itm_array){
        $tax = ($this->getSubtotal($itm_array) * $this->SALES_TAX);
        return $tax;
    }
    
    
        #If cart not empty, return total price for items in cart , else return 0.
     
    public function getTotal($itm_array){
        $total = ($this->getTax($itm_array) + $this->getSubtotal($itm_array));
        return $total;
    }
    
}
