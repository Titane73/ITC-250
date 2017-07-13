<?php 
    include 'includes/config.php';
    include 'menu_item_class.php';
    include 'includes/header.php';
    include 'food_cart.php';
    
    $cart = new Cart();
    setlocale(LC_MONETARY, 'en_US');

?>

<h1>We Have Dogs, Burgers and Salads!</h1><p>

<section>
    <!-- START HTML FORM -->
    <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
		
        <!-- Iterate across each food item in the menu array. -->
        <h2>These Are What We Have To Offer:</h2>   
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
        
       
 <br /><br /><br />       

	<div>
		<input type="Submit" value="Click This To Place Your Order!" />
	</div>
    </form>
	<!-- END HTML FORM -->
</section>
<?php include 'includes/aside2.php';?>
