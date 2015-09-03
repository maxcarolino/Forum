<?php

class User extends AppModel
{
   public $validated;
   public $validation    =  array (
      'username'         => array (
	        'length' => array ('validate_between', 4, 20,),
                'valid'  => array ('isUsernameValid'),
                'empty'  => array ('isUsernameEmpty'),
      ),
      'password'         => array (
                'length' => array ('validate_between', 4, 20,),
                'valid'  => array ('isPasswordValid'),
                'empty'  => array ('isPasswordEmpty'),
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
      if(!$this->validate()) {
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
      if(!$this->validate()) {
	  throw new ValidationException('Oops! please re-enter your credentials');
      }

      $db = DB::conn();
   
      $user_credentials = $db->row('SELECT user_id, username FROM user WHERE username = ? AND password = ?', 
      array($this->username, md5($this->password))
      );

      if(!$user_credentials) {
         $this->validated = false;
         throw new RecordNotFoundException('Your username/password doesnt match any of our records');
      }
      $_SESSION['user_id']  = $user_credentials['user_id'];
      $_SESSION['username'] = $user_credentials['username'];
      $this->validated = true;
   }
}
