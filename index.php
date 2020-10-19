<?php include "header.php" ?>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <!-- Slide One - Set the background image for this slide in the line below -->
    <div class="carousel-item active" style="background-image: url('./assets/img/slide1.jpg')">
      <div class="carousel-caption d-none d-md-block">
        <div class="carousel-caption d-none d-md-block" style="background: rgba(0, 0, 0, 0.6);">
          <h2 class="display-4">Welcome!</h2>
          <p class="lead">Thanks for testing my work.</p>
          <?php
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            
          }else{
            echo '<a class="btn btn-primary" href="./register.php" role="button">Register</a>';
            echo '<a class="btn btn-primary" style="margin-left:30px" href="./login.php" role="button">Login</a>';
          }?>
        </div>
        
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Précédent</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Suivant</span>
  </a>
</div>


<?php include "footer.php" ?>