<?php
session_start();
 
$page_title="Cart";
include 'layout_head.php';
 
$action = isset($_GET['action']) ? $_GET['action'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
 
if($action=='removed'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> was removed from your cart!";
    echo "</div>";
}
 
else if($action=='quantity_updated'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> quantity was updated!";
    echo "</div>";
}
 
if(count($_SESSION['cart_items'])>0){
 
    // get the product ids
     echo "<tr>";
    $ids = "";
    foreach($_SESSION['cart_items'] as $id => $quantity){
        $ids = $ids . $id . ",";
    }
     echo "</tr>";
 
    // remove the last comma
    $ids = rtrim($ids, ',');
 
    //start table
    echo "<table class='table table-hover table-responsive table-bordered'>";
 
        // our table heading
        echo "<tr>";
            echo "<th class='textAlignLeft'>Product Name</th>";
            echo "<th>Price (USD)</th>";
            echo "<th>Quantity</th>";
            echo "<th>Subtotal</th>";
            echo "<th>Action</th>";
        echo "</tr>";
 
        $query = "SELECT id, name, price FROM products WHERE id IN ({$ids}) ORDER BY name";
 
        $stmt = $con->prepare( $query );
        $stmt->execute();
 
        $total_price=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
 
            $quantity = $_SESSION['cart_items'][$id];
            echo "<tr>";
                echo "<td><div class='product-id' style='display:none;'>{$id}</div>{$name}</td>";
                echo "<td>&#36;{$price}</td>";
                 echo "<td>";
                    echo "<form class='update-quantity-form'>";
                        echo "<div class='input-group'>";
                            echo "<input type='number' name='quantity' value={$quantity} min='1' class='form-control' required>";
                            echo "<span class='input-group-btn'>";
                                echo "<button type='submit' class='btn btn-default update-quantity'>Update</button>";
                            echo "</span>";
                        echo "</div>";
                    echo "</form>";
                echo "</td>";
                $subtotal = $price * $quantity;
                echo "<td>&#36;{$subtotal}</td>";
                echo "<td>";
                    echo "<a href='remove_from_cart.php?id={$id}&name={$name}' class='btn btn-danger'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Remove from cart";
                    echo "</a>";
                echo "</td>";
            echo "</tr>";
 
            $total_price+=$subtotal;
        }
 
        echo "<tr>";
                echo "<td><b>Total</b></td>";
                echo "<td></td>";
                echo "<td></td>";
                if ($total_price == 0){
                    // clears array if the cart is empty. There might be cases when an item was not 
                    // added to the array correctly and so the cart appears to have items when really
                    // is empty
                    unset($_SESSION['cart_items']);
                }
                echo "<td>&#36;{$total_price}</td>";
                echo "<td>";
                    echo "<a href='#' class='btn btn-success'>";
                        echo "<span class='glyphicon glyphicon-shopping-cart'></span> Checkout";
                    echo "</a>";
                echo "</td>";
            echo "</tr>";
 
    echo "</table>";
}
 
else{
    echo "<div class='alert alert-danger'>";
        echo "<strong>No products found</strong> in your cart!";
    echo "</div>";
}
 
include 'layout_foot.php';

echo "<script>
$(document).ready(function(){
    $('.add-to-cart-form').on('submit', function(){
        var id = $(this).closest('tr').find('.product-id').text();
        var name = $(this).closest('tr').find('.product-name').text();
        var quantity = $(this).closest('tr').find('input').val();
        window.location.href = \"add_to_cart.php?id=\" + id + \"&name=\" + name + \"&quantity=\" + quantity + \"&page=1\";
        return false;
    });
    
    $('.update-quantity-form').on('submit', function(){
        var id = $(this).closest('tr').find('.product-id').text();
        var name = $(this).closest('tr').find('.product-name').text();
        var quantity = $(this).closest('tr').find('input').val();
        window.location.href = \"update_quantity.php?id=\" + id + \"&name=\" + name + \"&quantity=\" + quantity;
        return false;
    });
});
</script>";
?>
