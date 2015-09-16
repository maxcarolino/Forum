<?php

class User extends AppModel
{
    CONST MIN_LENGTH = 6;
    CONST MAX_LENGTH = 30;
    CONST MYSQL_ERROR_CODE = 1062;
   
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
            'valid'      => array ('is_email_valid'),
        ),
    );

    public function register()
    {
        if (!$this->validate()){
            throw new ValidationException('Oops! invalid credentials');
        }

        $db = DB::conn();

        $params = array(
            'username' => $this->username,
            'password' => password_hash($this->password, PASSWORD_BCRYPT),
            'email'    => $this->email
        );

        try {
            $db->insert('user', $params);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === self::MYSQL_ERROR_CODE) {
                throw new DuplicateEntryException('Duplicate Entry');
            }
        }
    }
  
    public function logInAccount()
    {
        $db = DB::conn();

        $user_account = $db->row('SELECT user_id, username, password FROM user WHERE
        username = ?', array($this->username)
        );
        //check if user is not found OR the provided credentials is wrong
        if (!$user_account OR !(password_verify($this->password, $user_account['password']))) { 
            $this->validated = false;
            throw new RecordNotFoundException('Invalid credentials!');
        }
            return new self($user_account);
    }

    public static function getUsername($user_id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT username FROM user WHERE user_id = ?',
        array($user_id));

        return $row['username'];
    }
}