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
 * @see cart.php 
 * @todo none
*/

    include 'menu.php';
    include 'cart.php';
    
    $cart = new Cart();
    setlocale(LC_MONETARY, 'en_US');

?>
<!DOCTYPE html>
<html lang="en">
    <head>    
        <title>Dana's Weiner Hut</title>
        <meta name="keywords" content="enter your keywords here" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Luckiest+Guy" rel="stylesheet"> 
    </head>
    <body>
        <div id="wrapper">
            <div class="banner">
                <h1>Dana's Weiner Hut</h1>
            </div>
            <header>
                <div class="dancinDog"></div>
            </header>
            <div class="tagline">
                <h1>Awesome Dogs, Burgers and Salads!</h1><br />
            </div>
            
            <section>
                <!-- START HTML FORM -->
                <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">

                    <!-- Iterate across each food item in the menu array. -->
                    <?php 
                        foreach($items as $item){
                            echo '<div class=menu_item>	
                                    <label>
                                        <h3>'.$item->name.'</h3>
                                        <p>'.$item->description.'</p>
                                        <select name="'.$item->name.'" required title="0" tabindex="15">
                                                <option value="0">Please choose the quantity:</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                        </select>
                                    </label>
                                </div>';
                            if(isset($_POST[str_replace(' ','_',$item->name)])){
                                if($_POST[str_replace(' ','_',$item->name)] > 0){
                                    $item->quantity = intval($_POST[str_replace(' ','_',$item->name)]);
                                }
                            }
                        }
                    ?>
                    <div class="submit">
                        <input type="Submit" id="submit" value="Click Here To Total Up Your Order!" />
                    </div>
                
                </form>
                <!-- END HTML FORM -->
            </section>
            <aside>
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
                    
                    echo ''
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
                    
            </aside>
        </div>
    </body>
</html>