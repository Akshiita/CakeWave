<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

// Array to store validation messages
$message = array();

if(isset($_POST['order'])){
    // Sanitize and validate name
    $name = mysqli_real_escape_string($conn, htmlspecialchars($_POST['name']));
    if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
        $message[] = 'Invalid or empty name';
    }

    // Sanitize and validate number
    $number = mysqli_real_escape_string($conn, filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT));
    if (empty($number) || !filter_var($number, FILTER_VALIDATE_INT) || $number <= 0) {
        $message[] = 'Invalid or empty number';
    }

    // Sanitize and validate email
    $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Invalid or empty email format';
    }

    // Sanitize and validate payment method
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    if (!in_array($method, ['cash on delivery', 'credit card', 'paypal', 'paytm'])) {
        $message[] = 'Invalid payment method';
    }

    // Sanitize and validate address fields
    $flat = mysqli_real_escape_string($conn, htmlspecialchars($_POST['flat']));
    $street = mysqli_real_escape_string($conn, htmlspecialchars($_POST['street']));
    $city = mysqli_real_escape_string($conn, htmlspecialchars($_POST['city']));
    $state = mysqli_real_escape_string($conn, htmlspecialchars($_POST['state']));
    $country = mysqli_real_escape_string($conn, htmlspecialchars($_POST['country']));
    $pin_code = mysqli_real_escape_string($conn, filter_var($_POST['pin_code'], FILTER_SANITIZE_NUMBER_INT));

    // Validate address fields
    if (empty($flat) || empty($street) || empty($city) || empty($state) || empty($country) || empty($pin_code)) {
        $message[] = 'All address fields are required';
    }
    $success_message = '';
    // If there are no validation errors, proceed with processing the form
 if (empty($message)) {
    // Construct address
    $address = 'flat no. ' . $flat . ', ' . $street . ', ' . $city . ', ' . $state . ', ' . $country . ' - ' . $pin_code;

    // Calculate total price and construct cart products list
    $cart_total = 0;
    $cart_products = array();
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    // Prepare total products list
    $total_products = implode(', ', $cart_products);

    // Insert order into the database
    $order_query = mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', NOW())") or die('Order insertion query failed');

    if ($order_query) {
        // If order is successfully inserted, clear the cart
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Cart deletion query failed');
        $message[] ="Order placed successfully";
        
        // Redirect to a success page
        // header('Location: success.php');
        // exit();
    } else {
        // If order insertion fails, display an error message
        $message[] = 'Failed to place the order. Please try again later.';
    }
}

}

// if(isset($_POST['order'])){

//     $name = mysqli_real_escape_string($conn, $_POST['name']);
//     $number = mysqli_real_escape_string($conn, $_POST['number']);
//     $email = mysqli_real_escape_string($conn, $_POST['email']);
//     $method = mysqli_real_escape_string($conn, $_POST['method']);
//     $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
//     $placed_on = date('d-M-Y');

//     $cart_total = 0;
//     $cart_products[] = '';

//     $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
//     if(mysqli_num_rows($cart_query) > 0){
//         while($cart_item = mysqli_fetch_assoc($cart_query)){
//             $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
//             $sub_total = ($cart_item['price'] * $cart_item['quantity']);
//             $cart_total += $sub_total;
//         }
//     }

//     $total_products = implode(', ',$cart_products);

//     $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

//     if($cart_total == 0){
//         $message[] = 'your cart is empty!';
//     }elseif(mysqli_num_rows($order_query) > 0){
//         $message[] = 'order placed already!';
//     }else{
//         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
//         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
//         $message[] = 'order placed successfully!';
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>checkout order</h3>
    <p> <a href="home.php">home</a> / checkout </p>
</section>

<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">grand total : <span>$<?php echo $grand_total; ?>/-</span></div>
</section>

<section class="checkout">
<form action="" method="POST">

<h3>Place your order</h3>

<div class="flex">
    <div class="inputBox">
        <span>Your Name :</span>
        <input type="text" name="name" placeholder="enter your name" >
    </div>
    <div class="inputBox">
        <span>Your Number :</span>
        <input type="number" name="number" min="0" placeholder="enter your number" >
    </div>
    <div class="inputBox">
        <span>Your Email :</span>
        <input type="email" name="email" placeholder="enter your email" >
    </div>
    <div class="inputBox">
        <span>Payment Method :</span>
        <select name="method" required>
            <option value="cash on delivery">cash on delivery</option>
            <option value="credit card">credit card</option>
            <option value="paypal">paypal</option>
            <option value="paytm">paytm</option>
        </select>
    </div>
    <div class="inputBox">
        <span>Address line 01 :</span>
        <input type="text" name="flat" placeholder="e.g. flat no." >
    </div>
    <div class="inputBox">
        <span>address line 02 :</span>
        <input type="text" name="street" placeholder="e.g.  street name" >
    </div>
    <div class="inputBox">
        <span>City :</span>
        <input type="text" name="city" placeholder="e.g. jalandhar" >
    </div>
    <div class="inputBox">
        <span>State :</span>
        <input type="text" name="state" placeholder="e.g. punjab" >
    </div>
    <div class="inputBox">
        <span>Country :</span>
        <input type="text" name="country" placeholder="e.g. india" >
    </div>
    <div class="inputBox">
        <span>Pin code :</span>
        <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" >
    </div>
</div>

<input type="submit" name="order" value="order now" class="btn">

</form>


</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>