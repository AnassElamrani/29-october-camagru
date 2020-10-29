<?php require '../app/views/inc/navbar.php';?>

<div id="hold">
<div id="gridId" class="grid">

  <!-- we hide it -->
  <!-- <div id="hidden-div" class="hd">
        <div><img style="width:100%;" src="http://10.12.100.253/ok/public/images/anass5ec45938ecc4f.png"></div>
        <div id="right-side">
          <div id="comments-holder"></div>
          <div id="textAndButton">
            <textarea style="background-color:white;color:black;"type="text" name="comment" id="comment"></textarea>
            <input class="addComment" type="submit" value="Comment" onclick="addComment(189)">
          </div>
        </div>
</div> -->

      <!-- yes we do -->
  <?php foreach($data['posts'] as $post) :?>
  <?php
       $likeNumber = 0;
       $likeColor = 0;
       foreach($data['likes'] as $like){
        if($like->post_id == $post->postId && $like->like_parent_id == $_SESSION['user_id']){
          $likeColor = $likeColor + 1;
         }
       }
       foreach($data['likes'] as $like){
         if($like->post_id == $post->postId){
           $likeNumber = $likeNumber + 1;
          }
        }
        // echo "color: ".$likeColor;
      ?>
    <div class="under-grid">
      <p style="margin:0;"><?php echo $post->userName;?></p>
      <img  id="<?php echo $post->postId;?>" <?php if($post->user_id == $data['active_user_id'])
      {echo "onclick='Delete(this.id)'";} ?> src="<?php echo URLROOT;?>/public/images/<?php echo $post->imgName;?>">
      <?php if(isLoggedIn()) :?>
      <div class="details">
        <span id="<?php echo $post->postId;?>" onclick="like(this.id)" class="like material-icons"><?php echo $likeColor == 0 ? 'favorite_border' : 'favorite';?></span>
        <p id="LN<?php echo $post->postId;?>" style="flex-basis:80%;"><?php echo $likeNumber;?></p>
        <span id="<?php echo $post->postId;?>" onclick="comment(this.id)" class="comment material-icons" style="color:gray;">comment</span>
      </div>
        <!-- <p >created at <?php echo $post->postCreated;?></p> -->
      <?php endif;?>
    </div>
    
    <?php endforeach ;?>
</div>
<?php if($data['nbOfPages'] != 0) :?>
<nav id="pagination" aria-label="Page navigation example" style="margin-left:auto;margin-right:auto;">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="<?php echo URLROOT;?>/Posts/index">1</a></li>
    <?php $i = 1; while($i++ < $data['nbOfPages']) :?>
    <li class="page-item"><a class="page-link" href="<?php echo URLROOT;?>/Posts/index?page=<?php echo $i;?>"><?php echo $i;?></a></li>
<?php endwhile;?>
  </ul>
</nav>
<?php endif;?>
      </div>
<?php require '/var/www/html/ok/app/views/inc/footer.php';?>