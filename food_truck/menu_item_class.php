<?php
//food truck assignment 
//item class module

class item{

public $name = '';
public $description = '';
public $price = 0;
public $quantity = 0;


    public function __construct($name, $description, $price){

     $this->name = $name;
     $this->description = $description;
     $this->price = $price;
        
    }//end class constructor
    
}//end of item class

$items[] = new item('Classic Hot Dog', 'Kosher Hot Dog - $9.95', 9.95);
$items[] = new item('Chili Dog', 'Kosher Hot Dog, topped with mustard, chili and diced onions - $13.95', 13.95);
$items[] = new item('Seattle-style Hot Dog','Kosher Hot Dog, served with cream cheese and grilled onions on a toasted bun - $7.95', 7.95);
$items[] = new item('Chicago-style hot dog','Kosher all-beef on a steamed bun, topped with yellow mustard, chopped white onions, a dill pickle spear, tomato slices, Chicago-style relish, hot sport peppers, and a dash of celery salt - $6.95', 6.95);
$items[] = new item('Big Kahuna Burrito','A mega combo of steak, chicken, and chorizo, mixed with chipotle beans - $9.95', 9.95);
$items[] = new item('Gazpacho','Andalusian cold soup, served with fresh corn tortillas - $9.95', 9.95);

/*
// add Sides to item Class
$sides[] = new item('Guacamole','Hand-mixed, with Haas avocados and fresh cilantro - $1.95',1.95);
$sides[] = new item('Salsa','Our house salsa, with Habanero peppers and tomatillos. Extra spicy! - $0.95',0.95);
$sides[] = new item('Sour Cream','Have a little cream to cool off, after that salsa! - $0.45',0.45);
$sides[] = new item('Tortilla Chips','Freshly made with our own tortillas! - $1.95',1.95);
*/
//test
/*echo $item6->Name . "<br />";
echo $item6->Description . "<br />";
echo $item6->Price;
*/
