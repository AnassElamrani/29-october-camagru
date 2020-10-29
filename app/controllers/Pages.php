<?php
  class Pages extends Controller {
    public function __construct(){
      $this->homeModel = $this->model('Home');
    }
    
    public function index(){
        // Get Posts of the actual Page;
        
        $posts = $this->homeModel->getImages();
        // die("hello");
        // var_dump($likes);
        $data = [
        'posts' => $posts, 
        ];

      if(isLoggedIn()){
        header("Location: http://10.12.100.253/ok/Posts/index");
      }
      else {
        $this->view('pages/index', $data);
      }
    }

    public function about(){
      $data = [
        'title' => 'About Us'
      ];

      $this->view('pages/about', $data);
    }
  }