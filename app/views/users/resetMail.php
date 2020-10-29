<?php 
// echo CURRENT_DIR;
require '../app/views/inc/navbar.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Reset Mail</h2>
            <p>Enter your Email to receive reset password link</p>
            <form action="<?php echo URLROOT; ?>/users/resetMail" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo $data['email']?>" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err'] ;?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Send" class="btn btn-block bg-Success">
                    </div>
                </div>
        </div>
    </div>
</div>
<?require '../app/views/inc/footer.php'; ?>