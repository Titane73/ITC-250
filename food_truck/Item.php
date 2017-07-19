<?php
/*
 * @package foodTruck
 * @author Kyrrah Nork <kyrrahnork@gmail.com>
 * @author Nicole Brown <giantspork@gmail.com>
 * @author Ron Hamasaki <shinobu.kinjo@gmail.com>
 * @version 0.1 2017/07/17
 * @link http://kyrrahnork.com/sm17
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @see Cart.php 
 * @todo none
*/

class Item{
#set the variable initial values
public $name = '';
public $description = '';
public $price = 0;
public $quantity = 0;

#constructor
    public function __construct($name, $description, $price){

     $this->name = $name;
     $this->description = $description;
     $this->price = $price;
        
    }//end class constructor
    
}//end of item class

#fill array with items to be displayed on the menu

$items[] = new item('Classic Hot Dog','Kosher hot dog - $9.95', 7.95);
$items[] = new item('Chili Dog','Kosher hot dog, topped with mustard, chili and chopped white onions - $13.95', 9.95);
$items[] = new item('Seattle-style Hot Dog','Kosher Hot Dog, served with cream cheese and grilled onions on a toasted bun - $10.95', 7.95);
$items[] = new item('Chicago-style hot dog','Kosher all-beef on a steamed bun, topped with mustard, chopped white onions, dill pickle, tomato slices, Chicago-style relish, and celery salt - $13.95', 13.95);
$items[] = new item('Burger','1/3 lb. beef patty topped with onions, lettuce, tomato, mayo - $9.95', 9.95);
$items[] = new item('Cheese Burger','1/3 lb. beef patty topped with cheese, onions, lettuce, tomato, mayo - $8.95', 8.95);
$items[] = new item('Bacon Burger','1/3 lb. beef patty topped with bacon, onions, lettuce, tomato, mayo - $11.95', 11.95);
$items[] = new item('Salad','Plain salad - $5.95', 5.95);

/*
// add Sides to item Class
$sides[] = new item('Guacamole','Hand-mixed, with Haas avocados and fresh cilantro - $1.95',1.95);
$sides[] = new item('Salsa','Our house salsa, with Habanero peppers and tomatillos. Extra spicy! - $0.95',0.95);
$sides[] = new item('Sour Cream','Have a little cream to cool off, after that salsa! - $0.45',0.45);
$sides[] = new item('Tortilla Chips','Freshly made with our own tortillas! - $1.95',1.95);
*/
