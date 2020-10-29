<?php require '../app/views/inc/navbar.php'; ?>

<div class="card text-center">
  <div class="card-header">
    -
  </div>
  <div class="card-body">
      <?php if($_GET["status"] == "Success") :?>
    <h5 class="card-title">Check you Email</h5>
    <p class="card-text">We just sent a confirmation link to You Email . Verify your address and we'll get you all set up!</p>
  </div>
  <div class="card-footer text-muted">
    Email sent at : <?php echo $data['time'];?>
  </div>
<?php else:?>
    <h5 class="card-title">Something get Wrong</h5>
    <p class="card-text">We couldn't send you the confirmation mail</p>
  </div>
<?php endif;?>
</div>


