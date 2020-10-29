<h2>Comments</h2>
<div>
<img style="width:100%;" src="http://10.12.100.253/ok/public/images/<?php echo $data['img']->name;?>">
</div>
<div id="right-side">
<div id="comments-holder"></div>
<div id="textAndButton">
<textarea style="background-color:white;color:black;"type="text" name="comment" id="comment"></textarea>
<input class="addComment" type="submit" value="Comment" onclick="addComment(<?php echo $data['img']->id?>)">
</div>
</div>
</div>