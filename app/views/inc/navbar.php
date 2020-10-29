<?php session_start();
require 'header.php'; 
//ar_dump($_SESSION['user_id']);?>

<nav class="navbar">
  <ul class="Ca">
    <li><a href="http://10.12.100.253/ok">Camagru</a></li>
  </ul>
  <?php if(isset($_SESSION['user_id'])) :?>
  <ul class="rl">
    <li><a href="http://10.12.100.253/ok/Montages">Camera</a></li>
    <li id="Posts"><a href="http://10.12.100.253/ok/Posts/index">Posts</a></li>
    <li><a href="http://10.12.100.253/ok/Users/account">Account</a></li>
    <li><a href="http://10.12.100.253/ok/Users/logout">Logout</a></li>
  <?php else:?>
  <ul class="rl">
    <li id="Posts"><a href="http://10.12.100.253/ok/Posts/index">Posts</a></li>
    <li><a href="http://10.12.100.253/ok/Users/register">Sign up</a></li>
    <li><a href="http://10.12.100.253/ok/Users/login">Login</a></li>
  <?php endif;?>
  </ul>
  <div class="burger" onclick="slide()">
    <div></div>
    <div></div>
    <div></div>
  </div>
</nav>
<!-- <script src="http://10.12.100.253/ok/public/js/main.js"></script> -->