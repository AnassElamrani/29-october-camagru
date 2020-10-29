
<?php require '../app/views/inc/navbar.php';?>
<?php #var_dump($_SESSION['user_id']);?>
<div class="container mt-5">
<div class="jumbotron">
<h1 class="display-4">Welcome to Camagru </h1>
<p class="lead">The Greatest Web App To take cool pictures and share it with friends</p>
  <hr class="my-4">
  <p>Register to get all the features and start Enjoying Camagru</p>
  <p class="lead">
  <div class="row">
  <div class="col">
    <a class="btn btn-primary btn-lg" href="http://10.12.100.253/ok/Users/register" role="button">Register</a>
  </p>
  </div>
  <div class="col-10">
  <p class="lead">
    <a class="btn btn-success btn-lg" href="http://10.12.100.253/ok/Users/login" role="button">Login</a>
  </p>
  </div>
  </div>
  
</div>


<div id="caroussel" class="col-sm">
<?php foreach($data['posts'] as $image) :?>
<img src="images/<?php echo $image->name; ?>" alt="" class="sliders">
<?php endforeach ;?>
</div>


</div>
</div>
<?php require '../app/views/inc/footer.php' ;?>
<script type="text/javascript" src="js/slider.js"></script>
