<h1><em>Your order: </em></h1>

<p>
    <?php 
    
    foreach($items as $item){
        if($item->quantity > 0){
            $output = '<strong>'.$item->name.'</strong></br>';
            $output .= $item->quantity.' x $'.money_format('%!.2n',$item->price);
            $output .= ' = ';
            $output .= '$'.money_format('%!.2n',($item->quantity*$item->price)).'</br>';
            echo $output;
        }
    }
    ?>
</p>

<p>
    Subtotal: <?='$'.money_format('%!.2n',$cart->getSubtotal($items));?>
</p>
<p>
    Tax: <?='$'.money_format('%!.2n',$cart->getTax($items))?>
</p>
<p>
    <strong>Total: </strong><?='$'.money_format('%!.2n',$cart->getTotal($items))?>
</p>

<!--
Fixed number formatting
Added current cart item view