<?php 
// echo CURRENT_DIR;
require '../app/views/inc/navbar.php'; ?>

<?php if(isset($data['status']) && $data['status'] == "fail") : ?>

    <div class="card text-center">
  <div class="card-header">
    -
  </div>
  <div class="card-body">
    <h5 class="card-title">Welcome but ... </h5>
    <div class='alert alert-danger' role='alert'>Your account isn't active yet ,check your mailbox!</div>
  </div>
  <div class="card-footer text-muted">
</div>

<?php else :?>

    <div class="col-md-6 mx-auto">
        <div class="card card-body mt-5">
            <h2 style="margin-bottom:25px;">Account Login</h2>
            <form action="<?php echo URLROOT; ?>/users/login" method="post">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" name="name" value="<?php echo $data['name']?>" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['name_err'] ;?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="<?php echo $data['password']?>" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['password_err'] ;?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="http://10.12.100.253/ok/Users/resetMail" class="ssa">Forgot Password ?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mt-2">
                        <input type="submit" value="Login" class="btn btn-block bg-Success">
                    </div>
                </div>
        </div>
    </div>

<?php endif; ?>

<?php require '../app/views/inc/footer.php'; ?>