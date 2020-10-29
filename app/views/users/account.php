 <?php echo"-----"; ?>
 <?php require '../app/views/inc/navbar.php';  ?>
 <div class="container mt-5">
   
   
   <h3>Account Settings</h3> 
    <div class="row mt-5 mb-4">
        <!-- <div class="col"> -->
        <!-- <div> -->
  
        <div class="col-8 pr-0 pl-0">
          <li class="list-group-item">Name: <span><?php echo $data['user']->name;?></span></li>
        </div>
        <div class="col-4 pr-0 pl-0 ">
            <a class="list-group-item list-group-item-action" href="http://10.12.100.253/ok/Users/ChangeName">Change Name </a>
        </div>
           
        <div class="col-8 pr-0 pl-0 bg-light">
        <li class="list-group-item">Email: <span><?php echo $data['user']->email;?></span></li>
        </div>  
        <div class="col-4 pr-0 pl-0 justify-content-center">
          <a class="list-group-item list-group-item-action" href="http://10.12.100.253/ok/Users/ChangeEmail">Change Email </a>
        </div>

        <div class="col-8 pr-0 pl-0 bg-light">    
        <li class="list-group-item">Password: <span>**********</span></li>
        </div>
        <div class="col-4 pr-0 pl-0 justify-content-center">
        <a class="list-group-item list-group-item-action" href="http://10.12.100.253/ok/Users/ChangePassword">Change Password </a>
        </div>
    </div>
    <input type="checkbox" id="yes" name="active" <?php echo $data['checked'];?> onclick="EmailNotifOff(this.checked)">
    <label for='yes'>Receive notification mail when someone comment your posts</label>
</div>



</div>

<?php require '../app/views/inc/footer.php';  ?>
