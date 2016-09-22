<?php session_start() ?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">NäbbShop</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="productlist.php">Birds</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="shoppingcart.php">Shoppingcart</a></li>
    </ul>

    <!-- <form class="navbar-form navbar-right" role="search">
      <button type="submit" class="btn btn-default">Log out</button>
    </form> -->

    <?php
    if(array_key_exists('username', $_SESSION)) {
      $username = $_SESSION["username"];
    }
    else {
      $username = null;
    }


    echo "<ul class='nav navbar-nav navbar-right'>";
    if($username) {
      // Render logged in labels
      echo "<li><a href='#'>Currently logged in: $username</a></li>";
      echo "<li><a href='logout.php'>Logout</a></li>";
    }
    else {
      // Render logged out labels
      echo "<li><a href='login.html'>Login</a></li>";
      echo "<li><a href='signup.html'>Sign Up</a></li>";
    }
    echo "</ul>";
     ?>
  </div>
</nav>
