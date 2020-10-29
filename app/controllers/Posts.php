<?php

class Posts extends Controller {
    public function __construct() {
        $this->postModel = $this->model('Post');
    }

    public function index() {
        $totalPost = $this->postModel->totalPost();
        $nbOfPages = intval(ceil($totalPost/6));
        
        if(isset($_GET['page'])) {
            $actualPage = intval($_GET['page']);
            
            if($actualPage > $nbOfPages) {
                $actualPage = $nbOfPages;
            }
        } else {
            $actualPage = 1;
        }
        
        $startPost = ($actualPage - 1)*6;
        echo $startPage;
        // Get Posts of the actual Page;
        
        $posts = $this->postModel->getPosts($startPost);
        $likes = $this->postModel->getLikes();
        // die("hello");
        // var_dump($likes);
        $data = [
        'posts' => $posts,
        'likes' => $likes,
        'nbOfPages' => $nbOfPages,
        'active_user_id' => $_SESSION['user_id'] 
        ];

        $this->view('posts/index', $data);
    }

    public function addLike(){
        if(isLoggedIn()){
            if(isset($_GET['postId'])) {
                $data = [
                    'postId' => $_GET['postId'],
                    'userId' => $_SESSION['user_id']
                ];
                // check if post already liked;
                if($this->postModel->isLiked($data) === '0')
                {
                    $this->postModel->addLike($data);
                    echo "Like-";
                    // get number of likes of the actual post;to pass to javaScript as response then display it in HTML beside the like button;
                } else {
                    
                    $this->postModel->removeLike($data);
                    echo "Dislike-";
                }
                $PLN = $this->postModel->getLikesNumber($data['postId']);
                echo $PLN;
                    
            }
        }
    }

    public function comment() {
        if(isLoggedIn()){
            if (isset($_GET['postId'])) {
                $imgId = $_GET['postId'];
                // fetch for existing comments in the db;
                $postComments = $this->postModel->getPostComments($imgId);
                $json = json_encode($postComments);
                // print_r($postComments);
                print_r($json);
                // get image;
                $img = $this->postModel->getPostById($imgId);
                $data = [
                    'img' => $img
                ];
                $this->view('posts/comments', $data);
        }
    }}

    public function addComment() {
        if(isLoggedIn()){
            if(isset($_GET['comment']) && isset($_GET['postId']))
            {   
                $postId = $_GET['postId'];
                $post = $this->postModel->getPostById($postId);
                // comments table : |(ppi)post_parent_id:$imgId->user_id|(cpi)comment_parent_id:connectedUser|comment:GET|
                $data = [
                    'post_id' => $_GET['postId'],
                    'ppi' => $post->user_id,
                    'cpi' => $_SESSION['user_id'],
                    'cpn' => $_SESSION['user_name'],
                    'comment' => $_GET['comment']
                ];
                if($this->postModel->addComment($data) == true){
                    // echo "the query has been executed succesfully";
                    echo json_encode($data);
                }
                // commentMail;
                if($this->postModel->checkEmailNotif($data['ppi']) == '1'){
                    // send mail notif;
                    $postParent_email = $this->postModel->getPostParent($data['post_id']);
                    commentMail($postParent_email, $data['cpn'], $data['comment']);
                }
            } else {
                echo "fail";
            }
        }
    }
    public function delete(){
        if(isLoggedIn()){
            if(isset($_GET['postId'])){
                $postId = $_GET['postId'];
                $ret = $this->postModel->deletePost($postId);
                echo $ret;
            }
        }
    }
}


