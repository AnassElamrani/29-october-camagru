<?php

class Users extends Controller {
    public function __construct(){
        $this->UserModel = $this->model('User');
        session_start();
    }
    private $tes;
    public function register(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            if (empty($data['name']))
                $data['name_err'] = 'please enter a Name';
            else if(!preg_match("/[a-zA-Z]/", $data['name']))
                $data['name_err'] = 'name must contain at least one character';
            else if ($this->UserModel->name_already_exists($data['name']))
                $data['name_err'] = 'this name already exists please choose a unique one';
            if (empty($data['email']))
                $data['email_err'] = 'please enter an Email';
            else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
                $data['email_err'] = 'invalid email';
            else if($this->UserModel->CheckByEmail($data['email']))
                $data['email_err'] = 'this Email already exists';

            if (empty($data['password']))
                $data['password_err'] = 'please enter a Password';
            else if (strlen($data['password']) < 6)
                $data['password_err'] = 'Password must be at least 6 characters';
            else if (strlen($data['password']) > 255)
                $data['password_err'] = 'Password is too long';
            else if (!preg_match("/(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-])/", $data['password']))
                $data['password_err'] = 'Password must contains at least one upper case and lower case character, one digit, one special character';
            if (empty($data['confirm_password']))
                $data['confirm_password_err'] = 'please confirm password';
            else if ($data['password'] != $data['confirm_password'])
                $data['confirm_password_err'] = 'confirm passwrod does not match';
            // Make sure errors are empty
            else if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
                {
                    // die('Succes !')
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $data['vkey'] = md5(time(). $data['name']);
                    $vk = $data['vkey'];
                    if($this->UserModel->register($data)){
                        $subject = "Email Verification";
                        $headers = "From: Camagru\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $to = $data['email'];
                        $message = "<html><body><h1>Welcome to Camagru</h1><p>click the link bellow tovalidate your account</p>
                        <a href='http://10.12.100.253/ok/Users/verify?vkey=$vk'>Register Account</a></body></html>";

                    if(mail($to,$subject,$message,$headers))
                        {
                            $time = date('m/d/Y H:i:s', time()); 
                            // $this->sentVerificationmail($data);
                            header("Location: http://10.12.100.253/ok/Users/sentVerificationmail?status=Success&at=$time");
                        }
                    else
                        {
                            header('Location: http://10.12.100.253/ok/Users/sentVerificationmail?status=Fail');
                        }
                    }
                }
        }
        else
        {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
        }
        $this->view('users/register', $data);
    }
    
    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'name' => trim($_POST['name']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'password_err' => '',
            ];
            if (empty($data['name']))
            $data['name_err'] = 'please enter a Name';
            
            if (empty($data['password']))
            $data['password_err'] = 'please enter a Password';
            else if (strlen($data['password']) < 6)
            $data['password_err'] = 'Password must be at least 6 characters';
            // Make sure errors are empty
            else if (empty($data['name_err']) && empty($data['password_err']))
            {
                if($logeduserInfo = $this->UserModel->Login($data))
                {
                    if($this->UserModel->is_active($data) == true)
                    {
                        // die("hnasss");
                        $this->SaveSessionVar($logeduserInfo);
                    }
                    else
                    {
                        // die("hna");
                        $data['status'] = "fail";
                        // $data['div'] = "<div class='alert alert-danger' role='alert'>Your account isn't active yet ,check your mailbox!</div>";
                        // die("Your account isn't active yet ,check your mailbox");
                    }
                }
                else {    
                    $data['name_err'] = 'Name/password might be wrong';
                }
            }
        }
        else
        {
            $data = [
                'name' => '',
                'password' => "",
                'name_err' => '',
                'password_err' => ''
            ];
        }
        $this->view('users/login', $data);
    }
    public function SaveSessionVar($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_password'] = $user->password;
        header('Location: http://10.12.100.253/ok/');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_password']);
        session_destroy();
        header('Location: http://10.12.100.253/ok/Users/login');
    }

    public function verify(){
        if(isset($_GET['vkey']))
        {
            $vkey = $_GET['vkey'];
            // var_dump($vkey);
            if(($this->UserModel->is_active($data) == false) && $this->UserModel->CheckVkey($vkey) == true){
                $this->UserModel->activate_account($vkey);
                $this->view('users/verified');
            }
            else{
                echo "oups something goes wrong, we couldn't verify ur account";
            }
        }
    }
    public function resetMail()
    {
        // echo $_SERVER['REQUEST_METHOD'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'email' => trim($_POST['email']),
                'email_err' => ''
            ];
            
            if(empty(trim($_POST['email'])))
            $data['email_err'] = "Empty Password";
            //if email exists
            if(empty($data['email_err']) && $this->UserModel->CheckByEmail($data['email']))
            {
                $vkey = $this->UserModel->GetVkey($data['email']);
                
                $to = $data['email'];

                $headers = "From: Camagru\r\n";
                // $headers .= "CC: camagru.noreply.89@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
                $subject = "Reset Password";
                
                $message = "<html><body>";
                $message .= "<h1>Hello</h1>";
                $message .= "<p>Enter the link bellow to Reset Your password</p>"; 
                $message .= "<a href='http://10.12.100.253/ok/Users/reset?vkey=$vkey'";
                $message .= ">Reset Link</a>";
                $message .= "</html></body>";
                
                if(mail($to,$subject,$message,$headers))
                {
                    header('Location: http://10.12.100.253/ok/Users/sentResetmail?status=Succes');
                    die ("tsuft");
                }
                else
                {
                    header('Location: http://10.12.100.253/ok/Users/sentResetmail?status=Fail');
                    die("matsufetch");
                }
            }
            else 
            {
                $data['email_err'] = "Email Does not exits in Our database";
            }
        }
            // echo "!POST";
            $this->view('users/resetMail', $data);
    }

    public function reset()
    {
        // echo "apaaaa\n";
        // var_dump(CheckVkey($_GET['vkey']));
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $token = $_GET['vkey'];
            // echo "rPOST";
            $data = [
                'name' => trim($_POST['name']),
                'new_password' => trim($_POST['new_password']),
                'confirm_new_password' => trim($_POST['confirm_new_password']),
                'name_err' => '',
                'new_password_err' => '',
                'confirm_new_password_err' => ''
                
            ];
            
            if (empty($data['name']))
            $data['name_err'] = 'please enter the user Name';
            if (empty($data['new_password']))
            $data['new_password_err'] = 'please enter a Password';
            else if (strlen($data['new_password']) < 6)
            $data['new_password_err'] = 'Password must be at least 6 characters';
            if (empty($data['confirm_new_password']))
            $data['confirm_new_password_err'] = 'please confirm password';
            else if ($data['new_password'] != $data['confirm_new_password'])
            $data['confirm_new_password_err'] = 'confirm password does not match';
            else if(empty($data['name_err']) && empty($data['new_password_err']) && empty($data['confirm_new_password_err']))
            {
                // echo " 1 ";
                if($data['name'] = $this->UserModel->does_name_match_vkey($data['name'], $token))
                {
                    // echo " 2 ";
                    $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                    $this->UserModel->ResetPassword($data, $token);
                    die('safe tbdl l password');

                }
                else
                    die('Wrong Name');
            }
            // echo " 2 ";
            $this->view('users/Xreset', $data);
        }
        else if (isset($_GET['vkey']) && $this->UserModel->CheckVkey($_GET['vkey']))
        {
            $token = $_GET['vkey'];
            {
                // echo "r!POST";
                $data = [
                    'name' => '',
                    'confirm_password' => '',
                    'confirm_new_password' => '',
                    'token' => $token
                ];
            }
            $this->view('users/Xreset', $data);
        }

        else 
            die("Oops something goes wrong 'No vkey in the URL'");
    }

    public function sentVerificationmail(){
        if(isset($_GET['status']))
        {
            $data['status'] = $_GET['status'];
            $data['time'] = $_GET['at'];
            $this->view('users/emailsent', $data);
        }
    }

    public function account(){
        var_dump($checked);
        echo " 1okokokok";
        if(isset($_GET['checked'])){
            $checked = $_GET['checked'];
            var_dump($checked);
            if($checked == 'true'){
                echo "oui";
                // set email_notif to 1 in the db;
                $this->UserModel->emailNotif($_SESSION['user_id'], 1);
            } else {
                echo "non";
                // set email_notif to 0 in the db;
                $this->UserModel->emailNotif($_SESSION['user_id'], 0);
            }
        }
        if($this->UserModel-> checkEmailNotif($_SESSION['user_id']) == '1'){
            $flag = 'checked';
            // mail;
            // commentMail();
        } else {
            $flag = '';
        }
        echo "  --- here ---";
        preg_match("/(.+)\/(.+)\/(.+)/", $_GET['url'], $matches);
        // $matches[3]
        $user = $this->UserModel->getUserInfo($_SESSION['user_name']);
        $data = [
            'user' => $user,
            'checked' => $flag
        ];
        $this->view('users/account', $data);
    }

    public function ChangeName(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'new_name' => $_POST['new_name'],
                'confirm_new_name' => $_POST['confirm_new_name'],
                'new_name_err' => '',
                'confirm_new_name_err' => ''
            ];
            $ret = $this->UserModel->cn_check($data, $_SESSION['user_name']);
            if (empty($data['new_name']))
                $data['new_name_err'] = 'please enter a Name';
            else if(!preg_match("/[a-zA-Z]/", $data['new_name']))
                $data['new_name_err'] = 'name must contain at least one character';
            else if (!empty($ret))
                $data['new_name_err'] = $ret;
            
            if($data['new_name'] != $data['confirm_new_name'])
                $data['confirm_new_name_err'] = "Password does not match";

            if(empty($data['new_name_err']) && empty($data['confirm_new_name_err']))
            {
                if($this->UserModel->cn($data, $_SESSION['user_name']))
                {
                    $_SESSION['user_name'] = $data['new_name'];
                    // die("smytk tbdlt");
                    $data['div'] = "<div class='alert alert-primary' role='alert'>
                                        Name has been changed Successfully !
                                        </div>";                   
                }
                else
                    $data['div'] = '<div class="alert alert-danger" role="alert">Sorry an error has occured</div>';
            } else {
                $data['div'] = '<div class="alert alert-danger" role="alert">Check errors and retry again !</div>';                
            }
        }
        else{
            $data = [
                'new_name' => '',
                'confirm_new_name' => '',
                'new_name_err' => '',
                'confirm_new_name_err' => ''
            ];
        }
        $this->view('users/ChangeName', $data);
    }

    public function ChangeEmail(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'new_email' => $_POST['new_email'],
                'confirm_new_email' => $_POST['confirm_new_email'],
                'new_email_err' => '',
                'confirm_new_email_err' => ''
            ];
            $ret = $this->UserModel->ce_check($data, $_SESSION['user_email']);
            if (empty($data['new_email']))
                $data['new_email_err'] = 'please enter an Email';
            else if(!filter_var($data['new_email'], FILTER_VALIDATE_EMAIL))
                $data['new_email_err'] = 'invalid email';
            else if (!empty($ret))
                $data['new_email_err'] = $ret;
            
            if($data['new_email'] != $data['confirm_new_email'])
                $data['confirm_new_email_err'] = "Email does not match";

            if(empty($data['new_email_err']) && empty($data['confirm_new_email_err']))
            {
                if($this->UserModel->ce($data, $_SESSION['user_email']))
                {
                    $_SESSION['user_email'] = $data['new_email'];
                    $data['div'] = "<div class='alert alert-primary' role='alert'>
                    Email has been changed Successfully !
                    </div>";
                }
                else
                $data['div'] = '<div class="alert alert-danger" role="alert">Sorry an error has occured</div>';
            } else {
                $data['div'] = '<div class="alert alert-danger" role="alert">Check errors and retry again !</div>';
            }
        }
        else{
            $data = [
                'new_email' => '',
                'confirm_new_email' => '',
                'new_email_err' => '',
                'confirm_new_email_err' => ''
            ];
        }
        $this->view('users/ChangeEmail', $data);
    }

    public function ChangePassword(){
    
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'old_password' => $_POST['old_password'],
                'new_password' => $_POST['new_password'],
                'confirm_new_password' => $_POST['confirm_new_password'],
                'old_password_err' => '',
                'new_password_err' => '',
                'confirm_new_password_err' => ''
            ];
            // $ret = $this->UserModel->cp_check($data, $_SESSION['user_password']);
            if(empty($data['old_password']))
                $data['old_password_err'] = 'please enter the actual password';
            else if(!password_verify($data['old_password'], $_SESSION['user_password']))
                $data['old_password_err'] = 'wrong password';
            if (empty($data['new_password']))
                $data['new_password_err'] = 'please enter a Password';
            else if (strlen($data['new_password']) < 6)
                $data['new_password_err'] = 'Password must be at least 6 characters';
            else if (strlen($data['new_password']) > 255)
                $data['new_password_err'] = 'Password is too long';
            else if (!preg_match("/(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-])/", $data['new_password']))
                $data['new_password_err'] = 'Password must contains at least one upper case and lower case character, one digit, one special character';
                
            if (empty($data['confirm_new_password']))
                $data['confirm_new_password_err'] = 'please confirm password';
            else if ($data['new_password'] != $data['confirm_new_password'])
                $data['confirm_new_password_err'] = 'confirm passwrod does not match';
            else if (!empty($ret)){
                $data['new_password_err'] = $ret;
            }
            if(empty($data['new_password_err']) && empty($data['confirm_new_password_err']) && empty($data['old_password_err']))
            {
                echo "--".$_SESSION['user_password']."--";
                echo "**".password_hash($data['old_password'], PASSWORD_DEFAULT)."**";
                $hashed_password = password_hash($data['new_password'], PASSWORD_DEFAULT);
                if($this->UserModel->cp($hashed_password, $_SESSION['user_password']))
                {
                    $_SESSION['user_password'] = $hashed_password;
                    $data['div'] = "<div class='alert alert-primary' role='alert'>
                    Password has been changed Successfully !
                    </div>";
                }
                else
                {
                    $data['div'] = '<div class="alert alert-danger" role="alert">Sorry an error has occured</div>';
                }
            } else {
                $data['div'] = '<div class="alert alert-danger" role="alert">Check errors and retry again !</div>';
            }
        }
        else{
            $data = [
                'old_password' => '',
                'new_password' => '',
                'confirm_new_password' => '',
                'old_password_err' => '',
                'new_password_err' => '',
                'confirm_new_password_err' => ''
            ];
        }
        $this->view('users/ChangePassword', $data);
    }


}
