<?php

class Post {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPosts($start) {
        $this->db->query('SELECT *,
                         posts.id as postId,
                         accounts.id as accountId,
                         posts.created_at as postCreated,
                         accounts.created_at as accountCreated,
                         posts.name as imgName,
                         accounts.name as userName
                         FROM posts
                         INNER JOIN accounts
                         ON posts.user_id = accounts.id
                         ORDER BY posts.created_at DESC
                         LIMIT '.$start.', 6
                         ');
        
        return $this->db->resultset();
    }

    public function totalPost() {
        $this->db->query('SELECT * FROM posts');
        $this->db->execute();
        return($this->db->rowCount());
    }

    public function addLike($data) {
        $this->db->query('INSERT INTO likes (`post_id`, `like_parent_id`) VALUES (:postId, :userId)');
        $this->db->bind(':postId', $data['postId']);
        $this->db->bind(':userId', $data['userId']);
        $this->db->execute();
    }

    public function removeLike($data) {
        $this->db->query('DELETE FROM likes WHERE `post_id` = :postId AND `like_parent_id`= :userId');
        $this->db->bind(':postId', $data['postId']);
        $this->db->bind(':userId', $data['userId']);
        $this->db->execute();
    }

    public function isLiked($data) {
        $this->db->query("SELECT * FROM likes where `like_parent_id` = :userId AND `post_id` = :postId");
        $this->db->bind(':userId', $data['userId']);
        $this->db->bind(':postId', $data['postId']);
        $this->db->execute();
        $ret = $this->db->rowCount();
        if($ret > 0){
            return "2";
        } else {
            return "0";
        }
    }

    public function getLikes() {
        $this->db->query('SELECT * FROM likes');
        return $this->db->resultset();
    }

    public function getLikesNumber($postId){
        $this->db->query('SELECT * FROM likes WHERE post_id = '.$postId.'');
        $this->db->execute();
        $numberOfLikes = $this->db->rowCount();
        return($numberOfLikes);
    }

    public function getPostByid($postId) {
        $this->db->query('SELECT * FROM posts WHERE `id` = '.$postId.'');
        return $this->db->single();
    }

    public function addComment($data){
        $this->db->query('INSERT INTO comments (`post_parent_id`, `comment_parent_id`, `comment`, `post_id`) VALUES (:ppi, :cpi, :comment, :post_id)');
        $this->db->bind(':ppi', $data['ppi']);
        // die($data['post_id']);
        $this->db->bind(':cpi', $data['cpi']);
        $this->db->bind(':comment', $data['comment']);
        $this->db->bind(':post_id', $data['post_id']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // get comments and info about who c and more infos;
    public function getPostComments($postId){
        $this->db->query('SELECT *,
            comments.post_parent_id as PostOwnerId,
            comments.comment_parent_id as CommentOwnerId,
            comments.created_at as CommentCreatedAt,
            accounts.name as CommentOwnerName
            FROM comments
            INNER JOIN accounts 
            ON comments.comment_parent_id = accounts.id
            WHERE comments.post_id = '.$postId.'
        ');
        return $this->db->resultset();
    }

    //commentMail;

    public function checkEmailNotif($user_id){
        $this->db->query('SELECT email_notif from accounts WHERE id = '.$user_id.'');
        $flag = $this->db->single();
        return($flag->email_notif);
        }
    ////

    public function getPostParent($post_id){
        $this->db->query('SELECT *
        FROM accounts
        INNER JOIN posts
        ON accounts.id = posts.user_id
        WHERE posts.id = '.$post_id.'
        ');
        $ret = $this->db->single();
        return($ret->email);
    }

    public function deletePost($postId){
        $this->db->query('DELETE FROM `posts` WHERE id = '.$postId.'');
        $this->db->execute();
        $this->db->query('DELETE FROM `likes` WHERE post_id = '.$postId.'');
        $this->db->execute();
        $this->db->query('DELETE FROM `comments` WHERE post_id = '.$postId.'');
        if($this->db->execute()){
            return($postId);
        }
    }
}