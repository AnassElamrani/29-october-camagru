<?php require '../app/views/inc/navbar.php';  ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>change Email</h2>
            <p>Enter a new Email</p>
            <?php if(!empty($data['div'])){echo $data['div'];}?>
            <form action="<?php echo URLROOT; ?>/users/ChangeEmail" method="post">
                <div class="form-group">
                    <label for="new_email">New Email</label>
                    <input type="email" name="new_email" value="<?php echo $data['new_email']?>" class="form-control form-control-lg <?php echo (!empty($data['new_email_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['new_email_err'] ;?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_new_email">Confirm New email</label>
                    <input type="email" name="confirm_new_email" value="<?php echo $data['confirm_new_email']?>" class="form-control form-control-lg <?php echo (!empty($data['confirm_new_email_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['confirm_new_email_err'] ;?></span>
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