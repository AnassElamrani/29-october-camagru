<?php require '../app/views/inc/navbar.php';  ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
                <?php if(!empty($data['div'])){echo $data['div'];}?>
            <h2>change Name</h2>
            <p>Enter a new Name</p>
            <form action="<?php echo URLROOT; ?>/users/ChangeName" method="post">
                <div class="form-group">
                    <label for="new_name">New Name</label>
                    <input type="text" name="new_name" value="<?php echo $data['new_name']?>" class="form-control form-control-lg <?php echo (!empty($data['new_name_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['new_name_err'] ;?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_new_name">Confirm New name</label>
                    <input type="text" name="confirm_new_name" value="<?php echo $data['confirm_new_name']?>" class="form-control form-control-lg <?php echo (!empty($data['confirm_new_name_err'])) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $data['confirm_new_name_err'] ;?></span>
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