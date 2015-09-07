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

   public function login()
   {
      $user = new User();
      $page = Param::get('page_next', 'login');

      switch ($page) {
      case 'login':
         break;
      case 'login_end':
         $user->username = trim(Param::get('username'));
         $user->password = trim(Param::get('password')); 
         try {
           $user->login_account();     
         } catch (RecordNotFoundException $e) {
           $page = 'login';
         }
         break;
      default:
         throw new NotFoundException("{$page} not found");
         break;
      }

      $this->set(get_defined_vars());
      $this->render($page);
   }

   public function logout()
   {

   }
}
