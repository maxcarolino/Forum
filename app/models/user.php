<?php

class User extends AppModel
{
   public $validated = true;
   public $validation    =  array (
      'username'         => array (
	        'length' => array ('validate_between', 4, 20,),
                'valid'  => array ('isUsernameValid'),
      ),
      'password'         => array (
                'length' => array ('validate_between', 4, 20,),
                'valid'  => array ('isPasswordValid'),
      ),
      'retype_password'  => array (
                'compare'=> array ('compare_password'),
      ),
      'email'            => array (
                'length' => array ('validate_between', 1, 35,),
      ),
   );

   public function register()
   {
      if(!$this->validate() OR User::account_exists($this->username, $this->email)) {
	  throw new ValidationException('Oops! please re-enter your credentials');
      }

      $db = DB::conn();
      $db->begin();

      $db->query('INSERT INTO user SET username = ?, password = ?, email = ?',
      array($this->username, md5($this->password), $this->email)
      );

      $db->commit();
   }
  
   public function validate_account()
   {
      $db = DB::conn();
   
      $user_credentials = $db->row('SELECT user_id, username FROM user WHERE username = ? AND password = ?', 
      array($this->username, md5($this->password))
      );

      if(!$user_credentials) { 
         $this->validated = false;
         throw new RecordNotFoundException('Your username/password doesnt match any of our records');
      }
      session_set_cookie_params(3600);
      session_start();
      session_regenerate_id(true);
      $_SESSION['user_id']  = $user_credentials['user_id'];
      $_SESSION['username'] = $user_credentials['username'];
   }

   public static function account_exists($username, $email)
   {
     $db = DB::conn();

     $row = $db->row('SELECT username, email FROM user WHERE username = ? OR email = ?',
     array($username, $email)
     );
  
     if($row) {
       return true;
     } 
   }
}
