<?php
session_start();
 
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
 
 
// update the item to the array
$_SESSION['cart_items'][$id]=$quantity;
 
// redirect to cart and tell the user it was updated to cart
header('Location: cart.php?action=added&id' . $id . '&name=' . $name);
?>
