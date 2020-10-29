<?php

class Montages extends Controller {

public function __construct(){
    $this->montageModel = $this->model('Montage');
}
    
public function index(){
    $this->view('montage/index');
}

public function upload(){
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']))
    {
        $stickerName = $_POST['sticker'];
        $stickerPath = './images/stickers/'.$stickerName.'.png';
        $image = $_FILES['image'];
        list($imageName, $imageType, $imageTmpName, $imageError, $imageSize) = array_values($image);
        $imageExt = strtolower(end(explode('.', $imageName)));
        $allowedExt = array('jpg', 'jpeg', 'png');

        if ($imageSize > 3000000){
            $response['status'] = 'fail';
            $response['response'] = "the image size must be 3mb or least";
            print_r($response);
        }
        if (in_array($imageExt, $allowedExt)){
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            $response['status'] = 'success';
            $response['response'] = base64_encode($imageData);

            $im = imagecreatefromstring($imageData);
            $src = imagecreatefrompng($stickerPath);
            list($width, $height) = getimagesize($stickerPath);
            $ret = imagecopy($im, $src, 150, 200, 0, 0, $width, $height);
            $tmpName = uniqid($_SESSION['user_name']).'.png';
            imagepng($im, './images/'.$tmpName, 0);
            $actualImg = file_get_contents('./images/'.$tmpName);
            $response['montage'] = base64_encode($actualImg);


            echo (json_encode($response));
        } else {
            $response['status'] = 'fail';
            $response['response'] = "You cannot upload files of this type!";
            print_r($response);
        }

        $data = [
            'imageName' => $tmpName,
            'userId' => $_SESSION['user_id'],
        ];
        $this->montageModel->stockImage($data);
    }
    // print_r($_FILES);
    // echo PHP_EOL . $_POST['sticker'];
    // echo sprintf('<img src="data:image/png;base64,%s" />', base64_encode($imageData));
}

    public function draw(){
        if(isLoggedIn() && isset($_POST['stickerName']) && isset($_POST['imgUrl'])) {
            $imgUrl = $_POST['imgUrl'];
            $stickerName = $_POST['stickerName'];
            // var_dump("--", $imgUrl);
            $encodedData = str_replace(' ','+',$imgUrl);
            $stickerPath = './images/stickers/'.$stickerName.'.png';
            list($width, $height) = getimagesize($stickerPath);
            $str = (explode(',', $encodedData))[1];
            $str = base64_decode($str);
            $im = imagecreatefromstring($str);
            $src = imagecreatefrompng($stickerPath);
            $ret = imagecopy($im, $src, 150, 200, 0, 0, $width, $height);
            $tmpName = uniqid($_SESSION['user_name']).'.png';
            $test = imagepng($im, './images/'.$tmpName, 0);
            // var_dump('****', $test);
            $actualImg = file_get_contents('./images/'.$tmpName);
            echo base64_encode($actualImg);
            // store image_name and user_name into db;
            $data = [
                'imageName' => $tmpName,
                'userId' => $_SESSION['user_id'],
            ];
            // echo "-------";
            $this->montageModel->stockImage($data);
        } else {
            echo "nn";
        }
    }
}