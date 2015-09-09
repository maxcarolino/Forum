<?php

class User extends AppModel
{
    CONST MIN_LENGTH = 6;
    CONST MAX_LENGTH = 30;
   
    public $validated = true;

    public $validation   =  array (
        'username'       => array (
            'length'     => array ('validate_between',
                                  self::MIN_LENGTH, self::MAX_LENGTH,),
            'valid'      => array ('is_username_valid'),
        ),
        'password'       => array (
            'length'     => array ('validate_between',
                                  self::MIN_LENGTH, self::MAX_LENGTH,),
            'valid'      => array ('is_password_valid'),
        ),
        'retype_password'=> array (
            'compare'    => array ('compare_password'),
        ),
        'email'          => array (
            'length'     => array ('validate_between',
                                  self::MIN_LENGTH, self::MAX_LENGTH,),
        ),
    );

    public function register()
    {
        if (!$this->validate() OR $this->isUsernameExists($this->username)
        OR $this->isEmailExists($this->email)) {
            throw new ValidationException('Oops! invalid credentials');
        }

        $db = DB::conn();
        $db->begin();

        $params = array(
            'username' => escape_string($this->username),
            'password' => md5(escape_string($this->password)),
            'email'    => escape_string($this->email)
        );

        $db->insert('user', $params);
        $db->commit();
    }
  
    public function logInAccount()
    {
        $db = DB::conn();

        $user_account = $db->row('SELECT user_id, username FROM user WHERE
        username = ? AND password = ?', 
        array(escape_string($this->username), md5(escape_string($this->password)))
        );

        if (!$user_account) { 
            $this->validated = false;
            throw new RecordNotFoundException('Invalid username/password!');
        }

        return $user_account;
    }

    public function isUsernameExists($username)
    {
        $db = DB::conn();

        $row = $db->row('SELECT username FROM user WHERE username = ?',
        array($username));

        if ($row) {
            return true;
        } 
    }
   
    public function isEmailExists($email)
    {
        $db = DB::conn();

        $row = $db->row('SELECT email FROM user WHERE email = ?',
        array($email));
  
        if ($row) {
            return true;
        } 
    }

    public static function getUsername($user_id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT username FROM user WHERE user_id = ?',
        array($user_id));

        return $row['username'];
    }
}