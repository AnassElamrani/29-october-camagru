<?php require '../app/views/inc/navbar.php';  ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Change Password</h2>
            <p>Enter a new Password</p>
            <?php if(!empty($data['div'])){echo $data['div'];}?>
            <form action="<?php echo URLROOT; ?>/users/ChangePassword" method="post">
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" name="old_password" value="<?php echo $data['old_password']?>" class="form-control form-control-lg <?php echo (!empty($data['old_password_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['old_password_err'] ;?></span>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" value="<?php echo $data['new_password']?>" class="form-control form-control-lg <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['new_password_err'] ;?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_new_password">Confirm New password</label>
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