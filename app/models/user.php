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
            'exists'     => array ('is_username_exists'),
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
            'valid'      => array ('is_email_valid'),
            'exists'     => array ('is_email_exists'),
        ),
    );

    public function register()
    {
        if (!$this->validate()){
            throw new ValidationException('Oops! invalid credentials');
        }

        $db = DB::conn();
        $db->begin();

        $params = array(
            'username' => escape_string($this->username),
            'password' => password_hash($this->password, PASSWORD_BCRYPT),
            'email'    => escape_string($this->email)
        );

        $db->insert('user', $params);
        $db->commit();
    }
  
    public function logInAccount()
    {
        $db = DB::conn();

        $user_account = $db->row('SELECT user_id, username, password FROM user WHERE
        username = ?', array(escape_string($this->username))
        );
        //check if user is not found OR the provided credentials is wrong
        if (!$user_account OR !(password_verify($this->password, $user_account['password']))) { 
            $this->validated = false;
            throw new RecordNotFoundException('Invalid username!');
        }
            return new self($user_account);
    }

    public static function isUsernameExists($username)
    {
        $db = DB::conn();

        $row = $db->row('SELECT username FROM user WHERE username = ?',
        array($username));

        if ($row) {
            return ($row) ? true : false;
        } 
    }
   
    public static function isEmailExists($email)
    {
        $db = DB::conn();

        $row = $db->row('SELECT email FROM user WHERE email = ?',
        array($email));
  
        if ($row) {
            return ($row) ? true : false;
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