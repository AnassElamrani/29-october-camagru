<?php 
// echo CURRENT_DIR;
require '../app/views/inc/navbar.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Password Reset</h2>
            <p>Enter a new Password</p>
            <form action="<?php echo URLROOT; ?>/users/reset?vkey=<?php echo $data['token'];?>" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?php echo $data['name']?>" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['name_err'] ;?></span>
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="new_password" value="<?php echo $data['new_password']?>" class="form-control form-control-lg <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['new_password_err'] ;?></span>
                </div>
                <div class="form-group">
                    <label for="password">Confirm New Password</label>
                    <input type="password" name="confirm_new_password" value="<?php echo $data['confirm_new_password']?>" class="form-control form-control-lg <?php echo (!empty($data['confirm_new_password_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['confirm_new_password_err'] ;?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Submit" class="btn btn-block bg-Success">
                    </div>
                </div>
        </div>
    </div>
</div>
<?require '../app/views/inc/footer.php'; ?>