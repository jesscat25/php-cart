<?php
session_start();
 
$page_title="Products";
include 'layout_head.php';
 
// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "1";
$name = isset($_GET['name']) ? $_GET['name'] : "";
 
if($action=='added'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> was added to your cart!";
    echo "</div>";
}
 
if($action=='exists'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> already exists in your cart!";
    echo "</div>";
}
 
$query = "SELECT id, name, price FROM products ORDER BY name";
$stmt = $con->prepare( $query );
$stmt->execute();
 
$num = $stmt->rowCount();
 
if($num>0){
 
    //start table
    echo "<table class='table table-hover table-responsive table-bordered'>";
 
        // our table heading
        echo "<tr>";
            echo "<th class='textAlignLeft'>Product Name</th>";
            echo "<th>Price (USD)</th>";
            echo "<th>Quantity</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
 
            //creating new table row per record
            echo "<tr>";
                echo "<td>";
                    echo "<div class='product-id' style='display:none;'>{$id}</div>";
                    echo "<div class='product-name'>{$name}</div>";
                echo "</td>";
                echo "<td>&#36;{$price}</td>";

                echo "<td>";

                if(count($_SESSION['cart_items'])>0 && array_key_exists($id, $_SESSION['cart_items'])){
                    echo "<form class='add-to-cart-form'>";
                        echo "<div class='input-group'>";
                            echo "<input type='number' name='quantity' value='1' min='1' class='form-control' placeholder='Type quantity here...' disabled>";
                            echo "<span class='input-group-btn'>";
                                echo "<button class='btn btn-success' disabled>";
                                    echo "<span class='glyphicon glyphicon-shopping-cart'>";
                                    echo "</span>";
                                    echo "Added!";
                                echo "</button>";                   
                            echo "</span>";
                        echo "</div>";
                    echo "</form>";
                }
                else {
                    echo "<form class='add-to-cart-form'>";
                        echo "<div class='input-group'>";
                            echo "<input type='number' name='quantity' value='1' min='1' class='form-control' placeholder='Type quantity here...'>";
                            echo "<span class='input-group-btn'>";
                                echo "<button type='submit' class='btn btn-primary add-to-cart'>";
                                    echo "<span class='glyphicon glyphicon-shopping-cart'>";
                                    echo "</span>";
                                    echo "Add to cart";
                                echo "</button>";                   
                            echo "</span>";
                        echo "</div>";
                    echo "</form>";
                }
                echo "</td>";
            echo "</tr>";
        }
 
    echo "</table>";

    
}
 
// tell the user if there's no products in the database
else{
    echo "No products found.";
}
 
include 'layout_foot.php';

echo "<!-- jQuery library -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>

<!-- bootstrap JavaScript -->
<script src='js/bootstrap.min.js'></script>
<script src='js/bootstrap/docs-assets/js/holder.js'></script>

<script>
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
