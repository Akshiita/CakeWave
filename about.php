<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="home.php">Home</a> / About </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image" >
            <img src="images/who.jpg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>Explore a diverse menu featuring a wide array of flavors, fillings, and styles. Whether you crave classic vanilla, decadent chocolate, or unique exotic flavors, we have the perfect cake to cater to your taste buds.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>what we provide?</h3>
            <p>Dream it, and we'll bake it! Our custom cake service allows you to design the cake of your dreams. Whether it's a themed birthday cake, a unique wedding masterpiece, or a corporate event showstopper, we bring your visions to life in delicious form.</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>

        <div class="image">
            <img src="images/provide.jpg"alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/chef.png" alt="">
        </div>

        <div class="content">
            <h3>who we are?</h3>
            <p>Your satisfaction is our priority. We listen to your preferences, understand your needs, and tailor our creations to match your vision. From custom-designed wedding cakes that reflect your love story to everyday treats that bring smiles, we are dedicated to exceeding your expectations</p>
            <a href="#reviews" class="btn">clients reviews</a>
        </div>

    </div>

</section>

<section  class="reviews" id ="reviews">
   


  

 

    <h1 class="title">Client's reviews</h1>

     <div class="box-container">

        <div class="box">
            <img src="images/pic-1.png" alt="">
            <p>"The cake I ordered for my daughter's birthday was not only beautifully decorated but also incredibly delicious! It was a huge hit at the party, and everyone wanted seconds. Thank you for making her day extra special!"</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
             
            </div>
            <h3>John Deo</h3>
        </div>

        <div class="box">
            <img src="images/pic-2.png" alt="">
            <p>"I recently tried your gluten-free cupcakes, and I couldn't believe they were gluten-free! They were incredibly moist and flavorful. It's so great to have a place where I can indulge without worrying about my dietary restrictions."</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Willams Smith</h3>
        </div>

        <div class="box">
            <img src="images/pic-3.png" alt="">
            <p>"I'm a fan of your seasonal specials! The holiday-themed treats are not only adorable but also incredibly tasty. I look forward to your new creations every season. Keep up the fantastic work!"</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            
            </div>
            <h3>Michael</h3>
        </div>

        <!-- <div class="box">
            <img src="images/pic-4.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque ducimus, iure expedita voluptates. Minima, minus.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div> -->

        <!-- <div class="box">
            <img src="images/pic-5.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque ducimus, iure expedita voluptates. Minima, minus.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div> -->

        <!-- <div class="box">
            <img src="images/pic-6.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia animi consequatur nostrum cumque itaque ducimus, iure expedita voluptates. Minima, minus.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div> -->

    </div>  
     </section>












<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>