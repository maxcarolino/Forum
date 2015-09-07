<?php

class UserController extends AppController
{
   public function register()
   {
      $user = new User();
      $page = Param::get('page_next', 'register');
      $user->username = trim(Param::get('username'));
      $user->email = trim(Param::get('email'));

      switch ($page) {
      case 'register':
         break;
      case 'register_end':
         $user->password = trim(Param::get('password'));
         $user->retype_password = trim(Param::get('retype_password'));
         try {
            $user->register();
	 } catch (ValidationException $e) {
	    $page = 'register';
         }
         break;
      default:
         throw new NotFoundException("{$page} not found");
         break;
      }

      $this->set(get_defined_vars());
      $this->render($page);
   }

   public function log_in()
   {
      $user = new User();
      $page = Param::get('page_next', 'log_in');

      switch ($page) {
      case 'log_in':
         break;
      case 'log_in_end':
         $user->username = trim(Param::get('username'));
         $user->password = trim(Param::get('password')); 
         try {
            $user_account = $user->log_in_account();
            if ($user_account) {    
               session_set_cookie_params(3600);
               session_start();
               session_regenerate_id(true);
               $_SESSION['user_id']  = $user_account['user_id'];
               $_SESSION['username'] = $user_account['username'];
            }    
         } catch (RecordNotFoundException $e) {
           $page = 'log_in';
         }
         break;
      default:
         throw new NotFoundException("{$page} not found");
         break;
      }

      $this->set(get_defined_vars());
      $this->render($page);
   }

   public function log_out()
   {

   }
}
