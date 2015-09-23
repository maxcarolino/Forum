<?php

class User extends AppModel
{
    CONST MIN_LENGTH = 6;
    CONST MAX_LENGTH = 30;
    CONST NAME_MIN_LENGTH = 1;
    CONST NAME_MAX_LENGTH = 30;
    CONST DEPT_MIN_LENGTH = 2;
    CONST DEPT_MAX_LENGTH = 50;
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
        'firstname'      => array (
            'length'     => array ('validate_between',
                                   self::NAME_MIN_LENGTH, self::NAME_MAX_LENGTH),
        ),
        'lastname'       => array (
            'length'     => array ('validate_between',
                                   self::NAME_MIN_LENGTH, self::NAME_MAX_LENGTH),
        ),
        'email'          => array (
            'length'     => array ('validate_between',
                                  self::MIN_LENGTH, self::MAX_LENGTH,),
            'valid'      => array ('is_email_valid'),
        ),
        'department'     => array (
            'length'     => array ('validate_between',
                                   self::DEPT_MIN_LENGTH, self::DEPT_MAX_LENGTH),
        ),
    );

    public function register()
    {
        if (!$this->validate()) {
            throw new ValidationException('Oops! invalid credentials');
        }

        $db = DB::conn();

        $params = array(
            'username'   => $this->username,
            'password'   => password_hash($this->password, PASSWORD_BCRYPT),
            'firstname'  => $this->firstname,
            'lastname'   => $this->lastname,
            'email'      => $this->email,
            'department' => $this->department
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

        $user_account = $db->row('SELECT user_id, username, password FROM user WHERE BINARY
        username = ?', array($this->username));

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

    public static function getOwnProfile($user_id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT user_id, username, firstname, lastname, email, department FROM user WHERE user_id= ?',
        array($user_id));

        if (!$row) {
            throw new RecordNotFoundException('No record found');
        }
            return new self($row);
    }

    public function updateProfile($user_id)
    {

        if (!$this->validate()) {
            throw new ValidationException('Oops! invalid credentials');
        }

        $db = DB::conn();

        $params = array(
            'username'   => $this->username,
            'firstname'  => $this->firstname,
            'lastname'   => $this->lastname,
            'email'      => $this->email,
            'department' => $this->department
        );

        $where_params = array(
            'user_id' => $user_id
        );

        try {
            $db->update('user', $params, $where_params);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === self::MYSQL_ERROR_CODE) {
                throw new DuplicateEntryException('Duplicate Entry');
            }
        }
    }

    public function updatePassword()
    {
        if (!$this->validate()) {
            throw new ValidationException('Oops! invalid credentials');
        }

        $db = DB::conn();

        $db->update('user', array('password' => password_hash($this->password, PASSWORD_BCRYPT)),
             array('user_id' => $this->user_id));
    }

    public static function getUserId($username)
    {
        $db = DB::conn();

        $row = $db->row('SELECT user_id FROM user WHERE BINARY username = ?',
        array($username));

        return $row['user_id'];
    }
}