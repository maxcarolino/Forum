<?php

class User extends AppModel
{
    CONST MIN_LENGTH = 6;
    CONST MAX_LENGTH = 30;
   
    public $validated = true;

    public $validation   =  array (
        'username'       => array (
            'length'     => array ('validate_between', self::MIN_LENGTH, self::MAX_LENGTH,),
            'valid'      => array ('isUsernameValid'),
        ),
        'password'       => array (
            'length'     => array ('validate_between', self::MIN_LENGTH, self::MAX_LENGTH,),
            'valid'      => array ('isPasswordValid'),
        ),
        'retype_password'=> array (
            'compare'    => array ('compare_password'),
        ),
        'email'          => array (
            'length'     => array ('validate_between', self::MIN_LENGTH, self::MAX_LENGTH,),
        ),
    );

    public function register()
    {
        if (!$this->validate() OR $this->username_exists($this->username) OR $this->email_exists($this->email)) {
            throw new ValidationException('Oops! please re-enter your credentials');
        }

        $db = DB::conn();
        $db->begin();

        $params = array(
            'username' => escapeString($this->username),
            'password' => md5(escapeString($this->password)),
            'email'    => escapeString($this->email)
        );

        $db->insert('user', $params);
        $db->commit();
    }
  
    public function log_in_account()
    {
        $db = DB::conn();

        $user_account = $db->row('SELECT user_id, username FROM user WHERE username = ? AND password = ?', 
        array(escapeString($this->username), md5(escapeString($this->password)))
        );

        if (!$user_account) { 
            $this->validated = false;
            throw new RecordNotFoundException('Your username/password doesnt match any of our records');
        }

        return $user_account;
    }

    public function username_exists($username)
    {
        $db = DB::conn();

        $row = $db->row('SELECT username FROM user WHERE username = ?', array($username));

        if ($row) {
            return true;
        } 
    }
   
    public function email_exists($email)
    {
        $db = DB::conn();

        $row = $db->row('SELECT email FROM user WHERE email = ?', array($email));
  
        if ($row) {
            return true;
        } 
    }

    public static function get_username($user_id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT username FROM user WHERE user_id = ?', array($user_id));

        return $row['username'];
    }
}