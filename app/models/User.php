<?php
class User{
    
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function CheckByEmail($email){
        $this->db->query('SELECT * from accounts WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        if($this->db->rowCount() > 0)
            return true;
        else
            return false;
    }

    public function name_already_exists($name){
        $this->db->query('SELECT * FROM accounts WHERE name = :name');
        $this->db->bind(':name', $name);
        $this->db->execute();
        if($this->db->rowCount() > 0)
            return true;
        else
            return false;
    }

    public function Register($data)
    {
      $this->db->query('INSERT INTO accounts (name, email, password, created_at, vkey) VALUES (:name, :email, :password, :created_at, :vkey)');
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      $this->db->bind(':created_at', date("y-m-d"));
      $this->db->bind(':vkey', $data['vkey']);
      if($this->db->execute())
      {return true;}else{return false;}
    }

    public function Login($data)
    {
        $this->db->query("SELECT * FROM accounts WHERE `name` = :name");
        $this->db->bind(':name', $data['name']);
        $row = $this->db->single();
        if(password_verify($data['password'], $row->password))
            return($row);
        else
            return false;
    }

    public function is_active($data){
        $this->db->query("SELECT * FROM accounts WHERE `name` = :name");
        $this->db->bind(':name', $data['name']);
        // $this->db->bind(':password', $data['password']);
        $res = $this->db->single();
        if(($res->active == 1) && (password_verify($data['password'], $res->password)))
            return true;
        else
            return false;
    }

    public function CheckVkey($vkey){
        $this->db->query("SELECT `vkey` FROM accounts WHERE `vkey` = :vkey");
        $this->db->bind(':vkey', $vkey);
        $row = $this->db->single();
        if($row->vkey)
            return true;
        else
            return false;
    }

    public function activate_account($vkey) {
        $this->db->query("UPDATE accounts SET `active` = '1' WHERE `vkey` = :vkey");
        $this->db->bind(':vkey', $vkey);
        $this->db->execute();
        return($this->db->rowCount());
    }

    public function GetVkey($email)
    {
        $this->db->query("SELECT * FROM accounts WHERE `email` = :email");
        $this->db->bind('email', $email);
        $row = $this->db->single();
        return($row->vkey);
    }
    public function does_name_match_vkey($name, $token)
    {
        $this->db->query("SELECT * FROM accounts WHERE `name` = :name AND `vkey` = :vkey");
        $this->db->bind(':name', $name);
        $this->db->bind(':vkey', $token);
        $cnt = $this->db->Single();
        return($cnt->name);
    }
    public function ResetPassword($data, $token)
    {
        $this->db->query("UPDATE accounts SET `password` = :password WHERE `name` = :name AND vkey = :vkey");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':vkey', $token);
        $this->db->bind(':password', $data['new_password']);
        $this->db->execute();
        return($this->db->rowCount());
    }

    public function cn($data, $user_name){
        $this->db->query("UPDATE accounts SET `name` = :new_name WHERE `name` = :old_name");
        $this->db->bind(':new_name', $data['new_name']);
        $this->db->bind(':old_name', $user_name);
        $this->db->execute();
        if($this->db->rowCount() > 0)
            return true;
        else
            return false;
    }
    public function cn_check($data, $user_name){
        $this->db->query("SELECT * FROM accounts WHERE `name` = :new_name");
        $this->db->bind(':new_name', $data['new_name']);
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            if($user_name == $row->name)
                $ret = "This is your old name";
            else
                $ret = "This name already exist";
        }
        else
            $ret = '';
        return $ret;
    }
/// change Email

    public function ce($data, $user_email){
        $this->db->query("UPDATE accounts SET `email` = :new_email WHERE `email` = :old_email");
        $this->db->bind(':new_email', $data['new_email']);
        $this->db->bind(':old_email', $user_email);
        $this->db->execute();
        if($this->db->rowCount() > 0)
            return true;
        else
            return false;
    }
    public function ce_check($data, $user_email){
        $this->db->query("SELECT * FROM accounts WHERE `email` = :new_email");
        $this->db->bind(':new_email', $data['new_email']);
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            if($user_email == $row->email)
                $ret = "This is your old email";
            else
                $ret = "This email already exist";
        }
        else
            $ret = '';
        return $ret;
    }

// change Password

public function cp($hashed_pwd, $user_password){
    $this->db->query("UPDATE accounts SET `password` = :new_password WHERE `password` = :old_password");
    $this->db->bind(':new_password', $hashed_pwd);
    $this->db->bind(':old_password', $user_password);
    $this->db->execute();
    if($this->db->rowCount() > 0)
        return true;
    else
        return false;
}
// public function cp_check($data, $user_password){
//     $this->db->query("SELECT * FROM accounts WHERE `password` = :new_password");
//     $this->db->bind(':new_password', $data['new_password']);
//     $row = $this->db->single();
//     if($this->db->rowCount() > 0)
//     {
//         if(password_verify($data['new_password'], $row->password))
//             $ret = "This is your old email";
//     }
//     else
//         $ret = '';
//     return $ret;
// }

public function getUserInfo($name){
    $this->db->query('SELECT * from accounts WHERE name = :name');
    $this->db->bind(':name', $name);
    $infos = $this->db->single();
    if($this->db->rowCount() > 0)
       {
            return ($infos);
       }
    else
        return false;
}

public function emailNotif($user_id, $flag){
    $this->db->query('UPDATE accounts SET  email_notif = :flag WHERE id = :user_id');
    $this->db->bind(':flag', $flag);
    $this->db->bind(':user_id', $user_id);
    $this->db->execute();
    echo "---------------";
}
public function checkEmailNotif($user_id){
    $this->db->query('SELECT email_notif from accounts WHERE id = '.$user_id.'');
    $flag = $this->db->single();
    return($flag->email_notif);
    }
}

