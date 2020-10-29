<?php 
// '$cm is commentParent';
function commentMail($to, $cm, $comment){

    $subject = "New comment";
    $headers = "From: Camagru\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = "$cm commented by : '$comment' on one of your posts";
    if(mail($to ,$subject,$message,$headers)){
        // echo('email mcha');
    }else {
        // echo("emai mamcha");
    }
}